<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

// class ChatbotController extends Controller
// {
//     public function handleQuery(Request $request)
//     {
//         $action = $request->action;
//         $message = trim($request->message);

//         // Logika 1: Cek Pesanan (Berdasarkan Nomor Order atau Keyword 'terakhir')
//         if ($action === 'cek_pesanan' || str_contains(strtolower($message), 'ord')) {

//             // A. Jika user mengetik 'terakhir'
//             if (strtolower($message) === 'terakhir') {
//                 $user = Auth::user(); // Pastikan user sudah login
//                 if (!$user) {
//                     return response()->json(['reply' => "Silakan login terlebih dahulu untuk melihat pesanan terakhir Anda."]);
//                 }

//                 $order = Order::where('customer_id', $user->id)
//                     ->latest('placed_at')
//                     ->first();

//                 if (!$order) {
//                     return response()->json(['reply' => "Mas Kens tidak menemukan riwayat pesanan atas nama Anda."]);
//                 }

//                 return $this->formatOrderResponse($order);
//             }

//             // B. Cari berdasarkan Nomor Order (ORD...)
//             $order = Order::where('order_no', 'ILIKE', "%{$message}%")->first();

//             if ($order) {
//                 return $this->formatOrderResponse($order);
//             }

//             return response()->json(['reply' => "Maaf, pesanan dengan nomor **{$message}** tidak ditemukan. Pastikan formatnya benar (Contoh: ORD12345678)."]);
//         } elseif ($action === 'cek_stok' || str_contains(strtolower($message), 'cek stok')) {
//             $produknya = Product::where('name', 'ILIKE', "%{$message}%")
//                 ->with(['variants.inventories.cabang']) // Eager load sampai ke branch
//                 ->first();

//             if ($produknya) {
//                 return $this->formatStokResponse($produknya);
//             }

//             return response()->json([
//                 'reply' => "Maaf, Mas Kens tidak menemukan produk dengan nama **{$message}**. Coba masukkan nama produk yang lebih spesifik?"
//             ]);
//         }

//         // Default Reply
//         return response()->json(['reply' => "Mas Kens kurang paham. Bisa pilih menu di atas atau hubungi Admin?"]);
//     }
//     private function formatOrderResponse($order)
//     {
//         $statusEmoji = [
//             'pending'    => ['icon' => '⏳', 'label' => 'PENDING', 'color' => '#f59e0b'],
//             'paid'       => ['icon' => '✅', 'label' => 'PAID', 'color' => '#10b981'],
//             'processing' => ['icon' => '⚙️', 'label' => 'PROSES', 'color' => '#3b82f6'],
//             'shipped'    => ['icon' => '🚚', 'label' => 'KIRIM', 'color' => '#8b5cf6'],
//             'complete'   => ['icon' => '🏁', 'label' => 'SELESAI', 'color' => '#059669'],
//             'cancelled'  => ['icon' => '❌', 'label' => 'BATAL', 'color' => '#ef4444'],
//         ];

//         $rawStatus = strtolower($order->status);
//         $st = $statusEmoji[$rawStatus] ?? ['icon' => '📦', 'label' => strtoupper($order->status), 'color' => '#6b7280'];

//         $total = number_format($order->total_amount, 0, ',', '.');
//         $tgl = $order->placed_at ? $order->placed_at->format('d M Y, H:i') : $order->created_at->format('d M Y, H:i');

//         $html = "
//         <div style='border-left: 4px solid #003d79; padding-left: 10px; margin-bottom: 10px;'>
//             <span style='font-size: 10px; color: #9ca3af; font-weight: bold;'>NOMOR PESANAN</span><br>
//             <span style='font-weight: bold; font-size: 16px; color: #003d79;'>#{$order->order_no}</span>
//         </div>
//         <div style='margin-bottom: 8px;'>
//             <span style='background-color: {$st['color']}; color: white; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: bold;'>
//                 {$st['icon']} {$st['label']}
//             </span>
//         </div>
//         <hr style='border: 0; border-top: 1px solid #eee; margin: 10px 0;'>
//         <table style='width: 100%; font-size: 13px; color: #4b5563;'>
//             <tr>
//                 <td style='padding-bottom: 5px;'>Total Bayar</td>
//                 <td style='text-align: right; font-weight: bold; color: #111827;'>IDR {$total}</td>
//             </tr>
//             <tr>
//                 <td>Waktu Order</td>
//                 <td style='text-align: right;'>{$tgl}</td>
//             </tr>
//         </table>
//         <div style='margin-top: 15px; font-size: 12px; background: #f0f7ff; padding: 8px; border-radius: 8px; color: #003d79; text-align: center;'>
//             Ada lagi yang bisa Mas Kens bantu? 😊
//         </div>
//     ";

//         return response()->json(['reply' => $html]);
//     }


//     private function formatStokResponse($product)
//     {
//         $reply = "
//         <div style='display: flex; align-items: center; gap: 10px; margin-bottom: 15px;'>
//             <div style='background: #003d79; color: white; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;'>🛒</div>
//             <div>
//                 <span style='font-size: 10px; color: #9ca3af; font-weight: bold; text-transform: uppercase;'>Informasi Produk</span><br>
//                 <span style='font-weight: bold; font-size: 15px; color: #111827;'>{$product->name}</span>
//             </div>
//         </div>
//     ";

//         $branchStock = [];
//         foreach ($product->variants as $variant) {
//             foreach ($variant->inventories as $inventory) {
//                 $branchName = $inventory->cabang->name ?? 'Cabang Utama';
//                 $branchStock[$branchName][] = [
//                     'name' => $variant->variant_name,
//                     'qty'  => $inventory->available
//                 ];
//             }
//         }

//         if (empty($branchStock)) {
//             return response()->json(['reply' => "😔 Maaf kak, stok **{$product->name}** saat ini sedang kosong di seluruh cabang kami."]);
//         }

//         foreach ($branchStock as $branch => $items) {
//             $reply .= "
//             <div style='background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);'>
//                 <div style='display: flex; align-items: center; gap: 5px; margin-bottom: 8px; color: #003d79; font-weight: bold; font-size: 13px;'>
//                     📍 <span>{$branch}</span>
//                 </div>
//                 <div style='display: flex; flex-direction: column; gap: 4px;'>";

//             foreach ($items as $item) {
//                 $color = $item['qty'] > 0 ? '#059669' : '#ef4444';
//                 $reply .= "
//                     <div style='display: flex; justify-content: space-between; font-size: 12px; color: #4b5563;'>
//                         <span>{$item['name']}</span>
//                         <span style='font-weight: bold; color: {$color};'>{$item['qty']} unit</span>
//                     </div>";
//             }

//             $reply .= "
//                 </div>
//             </div>";
//         }

//         $reply .= "
//         <p style='font-size: 12px; color: #6b7280; text-align: center; margin-top: 10px;'>
//             Tertarik memesan? Lihat detail produk <a href='{$product->id}' style='color: #3b82f6;'>disini</a>
//         </p>
//     ";

//         return response()->json(['reply' => $reply]);
//     }
// }


class ChatbotController extends Controller
{
    private $aiUrl = "https://ai.sumopod.com/v1/chat/completions";

    public function resetSession()
    {
        // Menghapus ingatan produk dan action sebelumnya
        Session::forget('chatbot_last_product');
        Session::forget('chatbot_last_action');

        return response()->json(['status' => 'success', 'message' => 'Memory cleared']);
    }

    public function handleQuery(Request $request)
    {
        $message = trim($request->message);
        $action = $request->action;

        // 1. Ambil Memory dari Session
        $lastProduct = Session::get('chatbot_last_product');

        // 2. Deteksi Konfirmasi (Dibuat lebih fleksibel, tidak pakai ^ dan $)
        // Jadi kalau user ketik "Iya benar" tetap masuk.
        $isConfirming = preg_match('/(iya|boleh|cek|stoknya|benar|betul|ya|ok|sip|tentu)/i', $message);

        // Jika ada lastProduct dan user mengonfirmasi, LANGSUNG eksekusi database
        if ($isConfirming && $lastProduct) {
            return $this->processStockQuery($lastProduct);
        }

        // 3. Jika pesan adalah trigger menu, langsung proses
        if ($message === "SAYA INGIN CEK PESANAN") {
            return $this->processOrderQuery("");
        }

        // 4. Minta respon AI
        $aiResponse = $this->getAIResponse($message, $action, $lastProduct);

        // 5. LOGIKA: CEK STOK (AI memberikan Tag)
        if (str_contains($aiResponse, '[ACTION_STOK]')) {
            preg_match('/produk: "(.*?)"/', $aiResponse, $matches);
            $productSearch = $matches[1] ?? null;

            if ($productSearch && !in_array($productSearch, ["nama produk", "nama_produk"])) {
                // SIMPAN KE SESSION DI SINI
                Session::put('chatbot_last_product', $productSearch);
                return $this->processStockQuery($productSearch);
            }
        }
        // --- TAMBAHAN PENTING ---
        // Jika AI tidak kasih tag, tapi di dalam kalimatnya dia menyebut nama produk 
        // (Contoh: "Apakah mau cek stok Genteng Rocky?"), kita ambil nama produknya untuk session berikutnya.
        else if (preg_match('/(stok|cek)\s+([A-Za-z0-9\s]+)\?/', $aiResponse, $matches)) {
            Session::put('chatbot_last_product', trim($matches[2]));
        }

        // 6. LOGIKA: CEK PESANAN
        if (str_contains($aiResponse, '[ACTION_ORDER]')) {
            return $this->processOrderQuery($message);
        }

        return response()->json(['reply' => $aiResponse]);
    }

    private function getAIResponse($userMessage, $currentAction = null, $lastProduct = null)
    {
        $apiKey = env('SUMOPOD_API_KEY');

        // Perketat instruksi agar AI tidak bertanya hal yang sama
        $systemPrompt = "Nama Anda Mas Kens, asisten cerdas Kencana. 
    Karakter: Ramah, solutif, panggil 'Kak'.
    
    KONTEKS SAAT INI: User membicarakan produk '" . ($lastProduct ?? "None") . "'.
    
    ATURAN WAJIB:
    1. Jika user menyebut nama produk (misal: 'Genteng Rocky'), balas HANYA: [ACTION_STOK] produk: \"Genteng Rocky\".
    2. Jika user konfirmasi (Iya/Benar) dan sudah ada konteks produk, balas HANYA: [ACTION_STOK] produk: \"$lastProduct\".
    3. Jika user tanya produk tapi belum spesifik, tanya balik nama produknya secara ramah.
    4. JANGAN bertanya 'Produk apa yang ingin dicek?' jika user sudah menyebutkan nama produk sebelumnya.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->aiUrl, [
                "model" => "gpt-4o-mini",
                "messages" => [
                    ["role" => "system", "content" => $systemPrompt],
                    ["role" => "user", "content" => $userMessage]
                ],
                "max_tokens" => 500,
                "temperature" => 0.3 // Turunkan temperature agar AI lebih patuh/tidak ngelantur
            ]);

            return $response->json('choices.0.message.content') ?? "Maaf Kak, coba ulangi lagi ya.";
        } catch (\Exception $e) {
            return "Mohon maaf koneksi sedang terganggu, ulangi dalam beberapa detik";
        }
    }

    private function processOrderQuery($message)
    {
        $user = Auth::user();

        // Logika cari pesanan terakhir (jika klik menu atau ketik 'terakhir')
        if (empty($message) || str_contains(strtolower($message), 'terakhir') || $message === "SAYA INGIN CEK PESANAN") {
            if (!$user) return response()->json(['reply' => "Silakan **Login** dulu ya Kak, supaya Mas Kens bisa cek riwayat pesanan Kakak."]);

            $order = Order::where('customer_id', $user->id)->latest('placed_at')->first();
            return $order ? $this->formatOrderResponse($order) : response()->json(['reply' => "Mas Kens belum menemukan riwayat pesanan atas nama Kak " . $user->name]);
        }

        // Cari nomor order ORDxxxx
        preg_match('/ORD\d+/', strtoupper($message), $matches);
        $search = $matches[0] ?? $message;

        $order = Order::where('order_no', 'ILIKE', "%{$search}%")->first();
        return $order ? $this->formatOrderResponse($order) : response()->json(['reply' => "Kode **{$search}** nggak ketemu di sistem Mas Kens, Kak."]);
    }

    private function processStockQuery($productName)
    {
        $produk = Product::where('name', 'ILIKE', "%{$productName}%")
            ->with(['variants.inventories.cabang'])
            ->first();

        // Jika tidak ketemu dengan nama, coba cari di level Variant (opsional tapi bagus untuk akurasi)
        if (!$produk) {
            $produk = Product::whereHas('variants', function ($q) use ($productName) {
                $q->where('variant_name', 'ILIKE', "%{$productName}%");
            })->with(['variants.inventories.cabang'])->first();
        }

        if (!$produk) {
            return response()->json([
                'reply' => "Waduh Kak, Mas Kens sudah cari produk **'{$productName}'** tapi belum ketemu di gudang. Bisa coba ketik nama produk yang lebih spesifik? (Contoh: Kencana Truss)"
            ]);
        }

        // Jika ketemu, panggil fungsi format stok
        return $this->formatStokResponse($produk);
    }

    private function formatOrderResponse($order)
    {
        $statusEmoji = [
            'pending' => ['icon' => '⏳', 'label' => 'PENDING', 'color' => '#f59e0b'],
            'paid' => ['icon' => '✅', 'label' => 'PAID', 'color' => '#10b981'],
            'processing' => ['icon' => '⚙️', 'label' => 'PROSES', 'color' => '#3b82f6'],
            'shipped' => ['icon' => '🚚', 'label' => 'KIRIM', 'color' => '#8b5cf6'],
            'complete' => ['icon' => '🏁', 'label' => 'SELESAI', 'color' => '#059669'],
            'cancelled' => ['icon' => '❌', 'label' => 'BATAL', 'color' => '#ef4444'],
        ];

        $st = $statusEmoji[strtolower($order->status)] ?? ['icon' => '📦', 'label' => strtoupper($order->status), 'color' => '#6b7280'];
        $total = number_format($order->total_amount, 0, ',', '.');
        $tgl = optional($order->placed_at)->format('d M Y, H:i') ?? $order->created_at->format('d M Y, H:i');

        $html = "<div style='border-left:4px solid #003d79;padding-left:10px;margin-bottom:10px;'><span style='font-size:10px;color:#9ca3af;font-weight:bold;'>ORDER NO</span><br><span style='font-weight:bold;font-size:16px;color:#003d79;'>#{$order->order_no}</span></div><div style='margin-bottom:8px;'><span style='background:{$st['color']};color:white;padding:2px 8px;border-radius:12px;font-size:10px;font-weight:bold;'>{$st['icon']} {$st['label']}</span></div><hr style='border:0;border-top:1px solid #eee;margin:10px 0;'><table style='width:100%;font-size:13px;'><tr><td>Total</td><td style='text-align:right;font-weight:bold;'>IDR {$total}</td></tr><tr><td>Waktu</td><td style='text-align:right;'>{$tgl}</td></tr></table>";

        return response()->json(['reply' => $html]);
    }

    private function formatStokResponse($product)
    {
        $reply = "<div style='display:flex;align-items:center;gap:10px;margin-bottom:15px;'><div style='background:#003d79;color:white;width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;'>🛒</div><div><span style='font-size:10px;color:#9ca3af;font-weight:bold;'>STOK PRODUK</span><br><span style='font-weight:bold;font-size:15px;'>{$product->name}</span></div></div>";

        $branchStock = [];
        foreach ($product->variants as $variant) {
            foreach ($variant->inventories as $inventory) {
                $branchStock[$inventory->cabang->name ?? 'Pusat'][] = ['n' => $variant->variant_name, 'q' => $inventory->available];
            }
        }

        foreach ($branchStock as $branch => $items) {
            $reply .= "<div style='background:white;border:1px solid #e5e7eb;border-radius:12px;padding:12px;margin-bottom:10px;'><div style='color:#003d79;font-weight:bold;font-size:13px;margin-bottom:8px;'>📍 {$branch}</div>";
            foreach ($items as $item) {
                $c = $item['q'] > 0 ? '#059669' : '#ef4444';
                $reply .= "<div style='display:flex;justify-content:space-between;font-size:12px;'><span>{$item['n']}</span><span style='font-weight:bold;color:{$c};'>{$item['q']} unit</span></div>";
            }
            $reply .= "</div>";
        }

        return response()->json(['reply' => $reply]);
    }
}
