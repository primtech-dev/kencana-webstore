<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use Illuminate\Http\Request;
use App\Models\Cart_Items;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\Branches;
use App\Models\Order;
use App\Models\Order_Items;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Mime\Message;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $selectedItemsJson = $request->input('selected_items');

        if (!$selectedItemsJson) {
            return redirect('/keranjang')->with('error', 'Tidak ada produk yang dipilih untuk checkout.');
        }


        $selectedItemIds = json_decode($selectedItemsJson, true);

        // dd($selectedItemIds);

        if (empty($selectedItemIds)) {
            return redirect('/keranjang')->with('error', 'Daftar produk yang dipilih kosong.');
        }

        $selectedCartItems = Cart_Items::whereIn('id', $selectedItemIds)
            ->whereHas('cart', function ($query) {
                $query->where('customer_id', Auth::guard('customer')->user()->id);
            })
            ->with(['cart', 'product', 'variant'])
            ->get()
            ->groupBy('cart.branch_id');

        // dd($selectedCartItems->toArray());
        $customer_addreses = Addresses::where('customer_id', Auth::guard('customer')->user()->id)->with('customer')->get();
        $customer_main_addreses = Addresses::where('customer_id', Auth::guard('customer')->user()->id)->where('is_default', 1)->with('customer')->first();

        // Contoh: Melemparkan data ke view checkout
        return view('frontend.checkout', [
            'selectedItems' => $selectedCartItems,
            'customer_addresses' => $customer_addreses,
            'customer_main_address' => $customer_main_addreses,
            'selectedItemIds' => $selectedItemIds
        ]);
    }

    public function buyNow(Request $request)
    {
        $variantId = $request->variant_id;
        $qty = $request->quantity;
        $branchId = $request->branch_id;

        $variant = ProductVariant::with('product')->findOrFail($variantId);
        $branch = Branches::find($branchId);

        // Buat struktur mirip cart_items
        $tempItems = collect([
            (object)[
                'id' => null,
                'cart' => (object)[
                    'branch_id' => $branchId,
                    'branch' => $branch
                ],
                'product' => $variant->product,
                'price_cents' => $variant->price,
                'variant' => $variant,
                'quantity' => $qty
            ]
        ]);

        // Group seperti hasil Cart_Items::whereIn(...)->groupBy('cart.branch_id')
        $selectedItems = collect([
            $branchId => $tempItems
        ]);

        $customer_addresses = Addresses::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $customer_main_address = Addresses::where('customer_id', Auth::guard('customer')->user()->id)
            ->where('is_default', 1)
            ->first();

        return view('frontend.checkout', [
            'selectedItems' => $selectedItems,
            'customer_addresses' => $customer_addresses,
            'customer_main_address' => $customer_main_address,
            'selectedItemIds' => []
        ]);
    }


    // Konstanta Status
    const ORDER_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PENDING = 'pending';
    const DEFAULT_SHIPPING_COST = 15000; // Contoh biaya ongkir default

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'shipping_details_json' => 'required|json',
            'items_json' => 'nullable',
        ]);

        $customerId = Auth::guard('customer')->user()->id;

        $shippingDetailsArray = json_decode($validated['shipping_details_json'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect('/keranjang')->with('error', 'Format data pengiriman tidak valid.')->withInput();
        }

        $sharedShippingDetail = $shippingDetailsArray ?: [
            'mode' => 'delivery',
            'address_id' => null,
            'shipping_cost' => 0,
        ];

        $orders = [];

        $itemsJsonValue = $request->input('items_json');
        $isCartCheckout = $itemsJsonValue && $itemsJsonValue !== '[]';

        // dd( $isCartCheckout, $itemsJsonValue);

        $cartItems = collect();

        if ($isCartCheckout) {
            $cartItemIds = json_decode($itemsJsonValue, true);

            if (json_last_error() !== JSON_ERROR_NONE && is_string($itemsJsonValue)) {
                $cartItemIds = [$itemsJsonValue];
            }

            $cartItemIds = array_filter((array)$cartItemIds);

            if (empty($cartItemIds)) {
                return redirect('/keranjang')->with('error', 'Item keranjang tidak ditemukan.')->withInput();
            }

            $cartItems = Cart_Items::whereIn('id', $cartItemIds)
                ->whereHas('cart', fn($q) => $q->where('customer_id', $customerId))
                ->with(['product', 'variant', 'cart.branch'])
                ->get();
        } else {
            // $productId = $request->input('product_id');
            $variantId = $request->input('variant_id');
            $quantity = $request->input('quantity', 1);
            $branchId = $request->input('branch_id');

            // dd( $variantId, $quantity);

            $variant = $variantId ? ProductVariant::find($variantId) : null;

            if (!$variant || $quantity <= 0) {
                return redirect('/keranjang')->with('error', 'Detail produk untuk Beli Langsung tidak valid.')->withInput();
            }


            $cartItems->push((object)[
                'product_id' => $variant ? $variant->product_id : null,
                'variant_id' => $variantId,
                'price_cents' => $variant ? $variant->price : 0,
                'quantity' => $quantity,
                'product' => $variant ? $variant->product : "null",
                'variant' => $variant,
                'cart' => (object)['branch_id' => $branchId, 'branch' => Branches::find($branchId)],
            ]);
        }

        $selectedItemsPerBranch = $cartItems->groupBy(fn($item) => $item->cart->branch_id);

        if ($selectedItemsPerBranch->isEmpty()) {
            $message = $isCartCheckout ? 'Keranjang Anda kosong atau item yang dipilih tidak valid.' : 'Detail produk tidak valid untuk Beli Langsung.';
            return redirect('/keranjang')->with('error', $message)->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($selectedItemsPerBranch as $branchId => $cartItemsForBranch) {

                $shippingDetail = $sharedShippingDetail;
                $mode = $shippingDetail['mode'] ?? 'delivery';
                $addressId = $shippingDetail['address_id'] ?? null;
                $requestShippingCost = $shippingDetail['shipping_cost'] ?? self::DEFAULT_SHIPPING_COST;

                $subtotalBeforeDiscount = 0;
                $lineItemsData = [];

                foreach ($cartItemsForBranch as $item) {
                    $unitPrice = $item->price_cents;
                    $quantity = $item->quantity;
                    $lineTotalBeforeDiscount = $unitPrice * $quantity;
                    $subtotalBeforeDiscount += $lineTotalBeforeDiscount;

                    $lineItemsData[] = [
                        'product_id' => $item->product_id,
                        'variant_id' => $item->variant_id,
                        'sku' => $item->variant->sku ?? $item->product->sku,
                        'product_name' => $item->product->name . ($item->variant ? ' - ' . $item->variant->variant_name : ''),
                        'unit_price' => $unitPrice,
                        'line_quantity' => $quantity,
                        'line_total_before_discount' => $lineTotalBeforeDiscount,
                        'line_discount' => 0,
                        'line_total_after_discount' => $lineTotalBeforeDiscount,
                        'line_tax' => null,
                        'line_total' => $lineTotalBeforeDiscount,

                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }

                // dd($addressId, $mode);

                $discountTotal = 0;
                $shippingCost = 0;

                if ($mode === 'delivery') {
                    if (!$addressId || $addressId === '0') {
                        throw new \Exception("Alamat pengiriman belum dipilih untuk cabang ID: {$branchId}");
                    }
                    $shippingCost = self::DEFAULT_SHIPPING_COST;
                }

                $subtotalAfterDiscount = $subtotalBeforeDiscount - $discountTotal;
                $taxTotal = 0;
                $totalAmount = $subtotalAfterDiscount + $shippingCost + $taxTotal;

                $orderData = [
                    'customer_id' => $customerId,
                    'branch_id' => $branchId,
                    'public_id' => Str::uuid(),
                    'order_no' => 'ORD' . strtoupper(Str::random(8)),
                    'status' => self::ORDER_STATUS_PENDING,
                    'payment_status' => self::PAYMENT_STATUS_PENDING,
                    'currency' => 'IDR',
                    'subtotal_before_discount' => $subtotalBeforeDiscount,
                    'discount_total' => $discountTotal,
                    'subtotal_after_discount' => $subtotalAfterDiscount,
                    'shipping_cost' => $shippingCost,
                    'tax_total' => $taxTotal,
                    'total_amount' => $totalAmount,
                    'payment_method_id' => $validated['payment_method_id'],
                    'placed_at' => Carbon::now(),
                    'meta' => json_encode(['delivery_mode' => $mode, 'selected_address_id' => $addressId]),
                    'address_id' => $addressId,
                    'delivery_method' => $mode,
                ];

                $order = Order::create($orderData);
                $orders[] = $order;

                $lineItemsWithOrderId = array_map(function ($item) use ($order) {
                    $item['order_id'] = $order->id;
                    return $item;
                }, $lineItemsData);

                Order_Items::insert($lineItemsWithOrderId);
            }

            if ($isCartCheckout) {
                $cartItems->each(fn($item) => $item->delete());
            }

            DB::commit();

            foreach ($orders as $order) {
                $this->WaNotification($order);
            }

            // $this->WaNotification($orders[0]);



            return redirect()->route('cart.index')
                ->with('success', 'Pesanan berhasil dibuat. Admin akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Creation Failed: ' . $e->getMessage(), ['exception' => $e]);

            $errorMessage = Str::contains($e->getMessage(), 'Alamat pengiriman belum dipilih') ?
                $e->getMessage() : 'Gagal membuat order. Silakan coba lagi.';

            return redirect('/keranjang')->with('error', $errorMessage)->withInput();
        }
    }


    // public function WaNotification($data_order)
    // {
    //     // Cek apakah relasi address ada dan memiliki data yang diperlukan (asumsi fields: street, city)
    //     $alamatLengkap = $data_order->address
    //         ? "{$data_order->address->street}, {$data_order->address->city}"
    //         : 'Pengambilan di tempat / Alamat tidak tersedia';

    //     // Inisialisasi dan perhitungan total produk (untuk bagian Rincian Biaya)
    //     $totalItemPrice = 0;
    //     foreach ($data_order->items as $item) {
    //         $itemTotal = $item->line_total_after_discount ?? $item->line_total_before_discount;
    //         $totalItemPrice += $itemTotal;
    //     }

    //     // --- Header Notifikasi ---
    //     $message = "🎉 *[ORDER BARU MASUK]* 🎉\n";
    //     $message .= "====================================\n";
    //     $message .= "Kami telah menerima pesanan baru yang siap diproses.\n";
    //     $message .= "====================================\n\n";

    //     // --- Detail Order & Pemesan ---
    //     $message .= "📝 *DETAIL PESANAN*\n";
    //     $message .= "------------------------------------\n";
    //     $message .= "📌 *No. Order:* `{$data_order->order_no}`\n";
    //     $message .= "🗓️ *Waktu Order:* " . \Carbon\Carbon::parse($data_order->placed_at)->format('d M Y, H:i') . " WIB\n";
    //     $message .= "🏪 *Cabang:* " . ($data_order->branch->name ?? 'Utama') . "\n";
    //     $message .= "👤 *Pemesan:* " . ($data_order->customer->full_name ?? 'Pelanggan') . "\n";
    //     $message .= "📞 *Telepon:* " . ($data_order->customer->phone ?? '-') . "\n";
    //     $message .= "📍 *Alamat Kirim:* {$alamatLengkap}\n\n";

    //     // --- Detail Item (Looping) ---
    //     $message .= "📦 *DETAIL ITEM ({$data_order->items->count()} Jenis)*\n";
    //     $message .= "------------------------------------\n";

    //     foreach ($data_order->items as $index => $item) {
    //         $itemTotal = $item->line_total_after_discount ?? $item->line_total_before_discount;
    //         $message .= "*" . ($index + 1) . ". {$item->product_name}*\n";
    //         // Tambahkan nama varian jika tersedia
    //         if (!empty($item->variant_name)) {
    //             $message .= "  Varian: " . $item->variant_name . "\n";
    //         }
    //         $message .= "  Qty: " . $item->line_quantity . "\n";
    //         $message .= "  Subtotal: Rp " . number_format($itemTotal, 0, ',', '.') . "\n";
    //     }

    //     // --- Rincian Biaya ---
    //     $shipping = $data_order->shipping_cost ?? 0;
    //     $discount = $data_order->discount_total ?? 0;

    //     $message .= "\n\n";
    //     $message .= "💰 *RINCIAN BIAYA*\n";
    //     $message .= "------------------------------------\n";
    //     $message .= str_pad("Subtotal Produk:", 20, ' ', STR_PAD_RIGHT) . "Rp " . number_format($totalItemPrice, 0, ',', '.') . "\n";
    //     if ($discount > 0) {
    //         $message .= str_pad("Diskon:", 20, ' ', STR_PAD_RIGHT) . "-Rp " . number_format($discount, 0, ',', '.') . "\n";
    //     }
    //     $message .= str_pad("Biaya Kirim:", 20, ' ', STR_PAD_RIGHT) . "Rp " . number_format($shipping, 0, ',', '.') . "\n";
    //     $message .= "------------------------------------\n";
    //     $message .= "✨ *TOTAL TAGIHAN:* " . "*Rp " . number_format($data_order->total_amount, 0, ',', '.') . "*\n";
    //     $message .= "------------------------------------\n\n";

    //     // --- Penutup ---
    //     $message .= "🙏 Mohon segera periksa dan proses pesanan ini.\n";
    //     $message .= "*Terima kasih atas kerja samanya!*";

    //     // Asumsi fungsi pengiriman WhatsApp sudah di definisikan
    //     $this->sendWhatsAppNotification("085847406716", $message);
    // }

    // public function WaNotification($data_order)
    // {
    //     // Cek Address
    //     $alamatLengkap = $data_order->address
    //         ? "{$data_order->address->street}, {$data_order->address->city}"
    //         : 'Pengambilan di tempat / Alamat tidak tersedia';

    //     // Perhitungan Total Item (Diperlukan untuk Rincian Biaya)
    //     $totalItemPrice = 0;
    //     foreach ($data_order->items as $item) {
    //         $itemTotal = $item->line_total_after_discount ?? $item->line_total_before_discount;
    //         $totalItemPrice += $itemTotal;
    //     }

    //     // --- Template Pesan ---
    //     $message = "*[ NOTIFIKASI ORDER BARU ]*\n";
    //     $message .= "====================================\n\n";

    //     // --- Detail Order dan Pelanggan ---
    //     $message .= "*[ A. INFORMASI DASAR ]*\n";
    //     $message .= "------------------------------------\n";
    //     $message .= str_pad("Nomor Order:", 18, ' ', STR_PAD_RIGHT) . " `{$data_order->order_no}`\n";
    //     $message .= str_pad("Waktu Order:", 18, ' ', STR_PAD_RIGHT) . \Carbon\Carbon::parse($data_order->placed_at)->format('d M Y, H:i') . " WIB\n";
    //     $message .= str_pad("Cabang:", 18, ' ', STR_PAD_RIGHT) . ($data_order->branch->name ?? 'Utama') . "\n";
    //     $message .= "------------------------------------\n";
    //     $message .= str_pad("Nama Pemesan:", 18, ' ', STR_PAD_RIGHT) . ($data_order->customer->full_name ?? 'Pelanggan') . "\n";
    //     $message .= str_pad("Telepon:", 18, ' ', STR_PAD_RIGHT) . ($data_order->customer->phone ?? '-') . "\n";
    //     $message .= str_pad("Pengiriman:", 18, ' ', STR_PAD_RIGHT) . "{$alamatLengkap}\n\n";


    //     // --- Detail Item (Looping) ---
    //     $message .= "*[ B. DAFTAR ITEM PESANAN ]* ({$data_order->items->count()} Jenis)\n";
    //     $message .= "------------------------------------\n";

    //     foreach ($data_order->items as $index => $item) {
    //         $itemTotal = $item->line_total_after_discount ?? $item->line_total_before_discount;
    //         $message .= "*" . ($index + 1) . ". {$item->product_name}*\n";

    //         // Tambahkan nama varian jika tersedia
    //         if (!empty($item->variant_name)) {
    //             $message .= "   - Varian: " . $item->variant_name . "\n";
    //         }

    //         $message .= "   - Qty: " . $item->line_quantity . "\n";
    //         $message .= "   - Subtotal: Rp " . number_format($itemTotal, 0, ',', '.') . "\n";
    //     }

    //     // --- Rincian Biaya ---
    //     $shipping = $data_order->shipping_cost ?? 0;
    //     $discount = $data_order->discount_total ?? 0;

    //     $message .= "\n\n";
    //     $message .= "*[ C. REKAPITULASI BIAYA ]*\n";
    //     $message .= "------------------------------------\n";
    //     // Menggunakan padding (str_pad) untuk perataan vertikal yang rapi
    //     $message .= str_pad("Subtotal Produk:", 20, ' ', STR_PAD_RIGHT) . "Rp " . number_format($totalItemPrice, 0, ',', '.') . "\n";

    //     if ($discount > 0) {
    //         $message .= str_pad("Diskon:", 20, ' ', STR_PAD_RIGHT) . "-Rp " . number_format($discount, 0, ',', '.') . "\n";
    //     }

    //     $message .= str_pad("Biaya Kirim:", 20, ' ', STR_PAD_RIGHT) . "Rp " . number_format($shipping, 0, ',', '.') . "\n";
    //     $message .= "------------------------------------\n";
    //     $message .= str_pad("*TOTAL TAGIHAN:*", 20, ' ', STR_PAD_RIGHT) . "*Rp " . number_format($data_order->total_amount, 0, ',', '.') . "*\n";
    //     $message .= "====================================\n\n";

    //     // --- Penutup ---
    //     $message .= "Mohon segera tindak lanjuti pesanan ini.\n";
    //     $message .= "Terima kasih.";

    //     // Kirim notifikasi
    //     $this->sendWhatsAppNotification("085847406716", $message);
    // }

    public function WaNotification($data_order)
{
    // Cek Address
    $alamatLengkap = $data_order->address
        ? "{$data_order->address->street}, {$data_order->address->city}"
        : 'Pengambilan di tempat / Alamat tidak tersedia';

    // Perhitungan Total Item (Diperlukan untuk Rincian Biaya)
    $totalItemPrice = 0;
    foreach ($data_order->items as $item) {
        $itemTotal = $item->line_total_after_discount ?? $item->line_total_before_discount;
        $totalItemPrice += $itemTotal;
    }

    // Tentukan lebar padding standar (misalnya 18 karakter untuk label)
    $padWidth = 18;

    // --- Template Pesan ---
    $message = "*[ NOTIFIKASI ORDER BARU ]*\n";
    $message .= "====================================\n\n";

    // --- Detail Order dan Pelanggan ---
    $message .= "*[ A. INFORMASI DASAR ]*\n";
    $message .= "------------------------------------\n";
    $message .= str_pad("Nomor Order:", $padWidth, ' ', STR_PAD_RIGHT) . " `{$data_order->order_no}`\n";
    $message .= str_pad("Waktu Order:", $padWidth, ' ', STR_PAD_RIGHT) . \Carbon\Carbon::parse($data_order->placed_at)->format('d M Y, H:i') . " WIB\n";
    $message .= str_pad("Cabang:", $padWidth, ' ', STR_PAD_RIGHT) . ($data_order->branch->name ?? 'Utama') . "\n";
    $message .= "------------------------------------\n";
    $message .= str_pad("Nama Pemesan:", $padWidth, ' ', STR_PAD_RIGHT) . ($data_order->customer->full_name ?? 'Pelanggan') . "\n";
    $message .= str_pad("Telepon:", $padWidth, ' ', STR_PAD_RIGHT) . ($data_order->customer->phone ?? '-') . "\n";
    $message .= str_pad("Pengiriman:", $padWidth, ' ', STR_PAD_RIGHT) . "{$alamatLengkap}\n\n";


    // --- Detail Item (Looping) ---
    $message .= "*[ B. DAFTAR ITEM PESANAN ]* ({$data_order->items->count()} Jenis)\n";
    $message .= "------------------------------------\n";

    // Lebar padding untuk detail item (misal: 10 karakter untuk label 'Qty', 'Varian')
    $itemPadWidth = 10; 

    foreach ($data_order->items as $index => $item) {
        $itemTotal = $item->line_total_after_discount ?? $item->line_total_before_discount;
        
        $message .= "\n";
        $message .= "*" . ($index + 1) . ". {$item->product_name}*\n";
        
        // Tambahkan nama varian
        if (!empty($item->variant_name)) {
            $message .= " " . str_pad("Varian:", $itemPadWidth, ' ', STR_PAD_RIGHT) . $item->variant_name . "\n";
        }
        
        // Tambahkan Qty
        $message .= " " . str_pad("Qty:", $itemPadWidth, ' ', STR_PAD_RIGHT) . $item->line_quantity . "\n";
        
        // Tambahkan Subtotal
        $message .= " " . str_pad("Subtotal:", $itemPadWidth, ' ', STR_PAD_RIGHT) . "Rp " . number_format($itemTotal, 0, ',', '.') . "\n";
    }

    // --- Rincian Biaya ---
    $shipping = $data_order->shipping_cost ?? 0;
    $discount = $data_order->discount_total ?? 0;
    
    // Lebar padding yang lebih lebar untuk rincian biaya agar angka sejajar
    $summaryPadWidth = 20;

    $message .= "\n\n";
    $message .= "*[ C. REKAPITULASI BIAYA ]*\n";
    $message .= "------------------------------------\n";
    
    $message .= str_pad("Subtotal Produk:", $summaryPadWidth, ' ', STR_PAD_RIGHT) . "Rp " . number_format($totalItemPrice, 0, ',', '.') . "\n";
    
    if ($discount > 0) {
        $message .= str_pad("Diskon:", $summaryPadWidth, ' ', STR_PAD_RIGHT) . "-Rp " . number_format($discount, 0, ',', '.') . "\n";
    }
    
    $message .= str_pad("Biaya Kirim:", $summaryPadWidth, ' ', STR_PAD_RIGHT) . "Rp " . number_format($shipping, 0, ',', '.') . "\n";
    $message .= "------------------------------------\n";
    
    $message .= str_pad("*TOTAL TAGIHAN:*", $summaryPadWidth, ' ', STR_PAD_RIGHT) . "*Rp " . number_format($data_order->total_amount, 0, ',', '.') . "*\n";
    $message .= "====================================\n\n";

    // --- Penutup ---
    $message .= "Mohon segera tindak lanjuti pesanan ini.\n";
    $message .= "Terima kasih.";

    // Kirim notifikasi
    $this->sendWhatsAppNotification("085708810388", $message);
}


    function sendWhatsAppNotification($phoneNumber, $message)
    {
        $apiKey = env('WA_API_KEY');
        $apiUrl = env('WA_API_URL');
        try {
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
            ])->post($apiUrl, [
                'recipient_type' => 'individual',
                'to' => $phoneNumber,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);
            return $response;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
