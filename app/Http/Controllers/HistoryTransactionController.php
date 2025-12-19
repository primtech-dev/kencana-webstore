<?php

namespace App\Http\Controllers;

use App\Models\Order; // Menggunakan Order sesuai kode Anda
use App\Models\Review_Images;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HistoryTransactionController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil ID customer yang sedang login
        // ASUMSI: Anda menggunakan 'customer' guard
        $customerId = Auth::guard('customer')->user()->id;

        // 2. Tentukan status filter dari query string (default: semua/null)
        $filterStatus = $request->query('status');

        // 3. Query dasar: Ambil transaksi milik customer ini
        $query = Order::where('customer_id', $customerId)
                            ->with(['items.product']); // Eager load relasi yang dibutuhkan di view

        // 4. Hitung jumlah transaksi untuk setiap status (untuk kebutuhan filter di view)
        $statusCounts = $this->getStatusCounts($customerId);

        // 5. Terapkan filter berdasarkan status
        if ($filterStatus && $filterStatus !== 'all') {
            // Kita harus pastikan status yang diterima adalah huruf kecil
            $query->where('status', strtolower($filterStatus));
        }
        
        // 6. Urutkan berdasarkan tanggal terbaru dan lakukan pagination
        $transactions = $query->orderBy('placed_at', 'desc')
                              ->paginate(10) // Tampilkan 10 transaksi per halaman
                              ->withQueryString(); // Memastikan filter status tetap ada di link pagination

        // 7. Definisikan pemetaan status yang sudah dipakai di view Blade (WAJIB)
        $statusFilters = [
            'all' => ['label' => 'Semua', 'class' => 'bg-primary text-white'],
            'pending' => ['label' => 'Menunggu Bayar', 'class' => 'bg-red-50 text-red-600 hover:bg-red-100'],
            'paid' => ['label' => 'Dibayar', 'class' => 'bg-orange-50 text-orange-600 hover:bg-orange-100'],
            'processing' => ['label' => 'Diproses', 'class' => 'bg-blue-50 text-blue-600 hover:bg-blue-100'],
            'shipped' => ['label' => 'Dikirim', 'class' => 'bg-indigo-50 text-indigo-600 hover:bg-indigo-100'],
            'complete' => ['label' => 'Selesai', 'class' => 'bg-green-50 text-green-600 hover:bg-green-100'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-gray-100 text-gray-700 hover:bg-gray-200'],
        ];

        // PERBAIKAN DI SINI: Nama view disesuaikan menjadi 'frontend.member.transactions'
        return view('frontend.member.transaksi', [ 
            'transactions' => $transactions,
            'statusCounts' => $statusCounts,
            'statusFilters' => $statusFilters,
            'activeStatus' => $filterStatus ?: 'all',
        ]);
    }

    protected function getStatusCounts(int $customerId): array
    {
        $counts = Order::where('customer_id', $customerId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        
        $lowerCaseCounts = [];
        foreach ($counts as $status => $total) {
            $lowerCaseCounts[strtolower($status)] = $total;
        }

        $lowerCaseCounts['all'] = array_sum($lowerCaseCounts);

        return $lowerCaseCounts;
    }

    public function show($order_no)
    {
        $customerId = Auth::guard('customer')->user()->id;

        // Cari transaksi berdasarkan order_no dan pastikan milik customer yang sedang login
        $transaction = Order::where('order_no', $order_no)
                            ->where('customer_id', $customerId)
                            ->with(['items.product'])
                            ->firstOrFail();

        return view('frontend.member.detail-transaksi', [
            'transaction' => $transaction,
        ]);
    }

    public function complete(Request $request, $order_no)
    {
        $customerId = Auth::guard('customer')->user()->id;

        // Cari transaksi berdasarkan order_no dan pastikan milik customer yang sedang login
        $transaction = Order::where('order_no', $order_no)
                            ->where('customer_id', $customerId)
                            ->firstOrFail();

        // Perbarui status transaksi menjadi 'complete' jika saat ini berstatus 'shipped'
        if ($transaction->status === 'shipped') {
            $transaction->status = 'complete';
            $transaction->updated_at = now();
            $transaction->save();

            return redirect()->route('history.transactions.show', ['order_no' => $order_no])
                             ->with('success', 'Transaksi telah ditandai sebagai selesai.');
        }

        return redirect()->route('history.transactions.show', ['order_no' => $order_no])
                         ->with('error', 'Transaksi tidak dapat ditandai sebagai selesai.');
    }

    public function storeReview(Request $request , $orderId)
    {
       $request->validate([
        'reviews' => 'required|array',
        'reviews.*.rating' => 'required|integer|min:1|max:5',
        'reviews.*.body' => 'required|string',
        'reviews.*.images.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
    ]);

   try {
    DB::transaction(function () use ($request, $orderId) {
        foreach ($request->reviews as $index => $data) {
            // 1. Simpan Data Review
            $review = Reviews::create([
                'public_id' => (string) Str::uuid(),
                'customer_id' => auth('customer')->id(),
                'order_id' => $orderId,
                'order_item_id' => $data['order_item_id'],
                'product_id' => $data['product_id'],
                'variant_id' => $data['variant_id'] ?? null,
                'rating' => $data['rating'],
                'body' => $data['body'],
                'is_verified_purchase' => true,
                'status' => 'published', 
            ]);

            // 2. Cek dan Simpan Gambar jika ada
            if ($request->hasFile("reviews.$index.images")) {
                foreach ($request->file('reviews')[$index]['images'] as $pos => $image) {
                    
                    // MODIFIKASI DI SINI:
                    // Folder akan menjadi: storage/app/public/reviews/{review_id}/nama_file.jpg
                    $path = $image->store("reviews/{$review->id}", 'public');

                    Review_Images::create([
                        'review_id' => $review->id,
                        'image_path' => $path,
                        'position' => $pos
                    ]);
                }
            }
        }
    });

    return redirect()->back()->with('success', 'Ulasan dan foto berhasil terkirim!');
} catch (\Exception $e) {
    return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
}
    }
}