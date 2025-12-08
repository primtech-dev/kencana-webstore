<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carts;
use App\Models\Cart_Items;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Branches;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    // public function index()
    // {
    //     $keranjang = Carts::where('customer_id', Auth::guard('customer')->id())->where('items', '!=', '[]')->with('items')->get();

    //     $total_harga_global = 0;

    //     foreach ($keranjang as $cart) {
    //         // Kita dapat langsung memanggil 'subtotal' pada koleksi items 
    //         // karena accessor sudah didefinisikan di model Cart_Items.
    //         $total_harga_global += $cart->items->sum('subtotal');
    //     }

    //     return view('frontend.keranjang', compact('keranjang'), compact('total_harga_global'));
    // }

   public function index()
{
    $customer_id = Auth::guard('customer')->id();

    if (!$customer_id) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // 1. Retrieve all carts for the customer with their items
    $keranjang = Carts::where('customer_id', $customer_id)
        ->with('items')
        ->get();

    // 2. Filter the collection: Keep only carts where the 'items' relation is not empty.
    $keranjang = $keranjang->filter(function ($cart) {
        return $cart->items->isNotEmpty();
    });
    // Note: The 'items' relation is already loaded due to the 'with('items')' above.
    // $cart->items will be a Collection object, and you use the 'isNotEmpty()' method.

    // 3. Recalculate the global total based on the filtered collection
    $total_harga_global = $keranjang->sum(function ($cart) {
        return $cart->items ? $cart->items->sum('subtotal') : 0;
    });

    return view('frontend.keranjang', compact('keranjang', 'total_harga_global'));
}


    public function addToCart(Request $request)
    {
        // dd($request->all());
        // 1. Validasi Input
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1|max:100', // Sesuai batasan di JS
            'branch_id' => 'required|exists:branches,id',
            // Asumsi: customer_id diambil dari user yang sedang login
        ]);

        $customerId = Auth::guard('customer')->id(); // Asumsi: Guard 'customer'
        $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity');
        $branchId = $request->input('branch_id');

        // Ambil data variant dan harga
        $variant = ProductVariant::findOrFail($variantId);
        $productId = $variant->product_id;

        // Ambil harga saat ini (price_cents) dari variant
        // Asumsi kolom harga di variant adalah 'price_cents'
        $priceCents = $variant->price;

        try {
            DB::beginTransaction();

            // 2. Cari atau Buat Keranjang (Cart)
            // Cari keranjang aktif (tanpa soft delete) untuk customer dan branch ini
            $cart = Carts::firstOrCreate(
                [
                    'customer_id' => $customerId,
                    'branch_id' => $branchId,
                ]
                // Jika keranjang baru dibuat, tidak ada tambahan data lain yang diperlukan
            );

            // 3. Cari atau Update Item Keranjang (CartItem)
            $cartItem = Cart_Items::where('cart_id', $cart->id)
                ->where('variant_id', $variantId)
                ->where('product_id', $productId)
                ->where('deleted_at', null)
                ->first();

            if ($cartItem) {
                // Item sudah ada, update kuantitas dan harga (sebagai snapshot)
                $newQuantity = $cartItem->quantity + $quantity;
                $cartItem->update([
                    'quantity' => $newQuantity,
                    // Biasanya harga di-update di setiap 'add to cart' untuk snapshot harga terbaru
                    'price_cents' => $priceCents,
                ]);
                $message = 'Kuantitas produk berhasil diperbarui di keranjang.';
            } else {
                // Item belum ada, buat item keranjang baru
                $cartItem = Cart_Items::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'quantity' => $quantity,
                    'price_cents' => $priceCents,
                ]);
                $message = 'Produk berhasil ditambahkan ke keranjang.';
            }

            DB::commit();

            // 4. Berikan Response
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cart->items()->count(), // Jumlah item unik di keranjang
                'total_items_quantity' => $cart->items()->sum('quantity'), // Total kuantitas
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan produk ke keranjang.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($itemId)
    {
        // 1. Cari item keranjang berdasarkan ID
        $item = Cart_Items::find($itemId);

        // 2. Periksa apakah item ditemukan
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item keranjang tidak ditemukan.'], 404);
        }


        if ($item->cart->customer_id !== auth()->guard('customer')->user()->id) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Item bukan milik Anda.'], 403);
        }

        // 4. Hapus item dari database
        try {
            $item->delete();

            // 5. Beri respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari keranjang.'
            ], 200);
        } catch (\Exception $e) {
            // Tangani error database atau lainnya
            return response()->json(['success' => false, 'message' => 'Gagal menghapus produk: ' . $e->getMessage()], 500);
        }
    }

    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            // 1. Cari item keranjang berdasarkan ID
            $cartItem = Cart_Items::find($itemId);

            if (!$cartItem) {
                return response()->json(['success' => false, 'message' => 'Item keranjang tidak ditemukan.'], 404);
            }

            // update qty nya di Cart_Items
            $new_quantity = $request->input('quantity');
            $cartItem->update(['quantity' => $new_quantity]);
        
            return response()->json([
                'success' => true,
                'message' => 'Kuantitas berhasil diperbarui.',
                'new_quantity' => $cartItem->quantity,
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui kuantitas: ' . $e->getMessage()], 500);
        }
    }
}
