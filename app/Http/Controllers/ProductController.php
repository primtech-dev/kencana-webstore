<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $defaultEagerLoads = ['images', 'categories', 'variants', 'variants.images'];

    public function index(Request $request)
    {
        $search = $request->get('search');

        $products = Product::query()
            ->where('is_active', true)

            // Filter berdasarkan nama atau SKU
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            })

            // Eager load relasi yang dibutuhkan
            ->with($this->defaultEagerLoads)

            ->paginate(15);

        // Mengembalikan View Blade dan meneruskan data produk ke dalamnya
        return view('frontend.index', [
            'products' => $products,
            'search' => $search
        ]);
    }

    /**
     * Menampilkan detail produk tunggal dalam sebuah View.
     *
     * @param  int $id
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    //public function show($id)
    //{
    //     // Temukan produk yang aktif dengan semua relasi penting
    //     $product = Product::with(
    //         array_merge($this->defaultEagerLoads, [
    //             'variants' => function ($query) {
    //                 $query->where('is_active', true)
    //                       ->where('is_sellable', true);
    //             }
    //         ])
    //     )
    //     ->where('is_active', true)
    //     ->find(2);

    //     // Penanganan jika produk tidak ditemukan (akan merender View 404 jika ada)
    //     if (!$product) {
    //          // Abort 404 akan mencari resources/views/errors/404.blade.php
    //          abort(404, 'Produk tidak ditemukan atau tidak aktif.');
    //     }

    //     dd($product->toArray());

    //     // Mengembalikan View Blade dan meneruskan data produk tunggal
    //     return view('products.show', [
    //         'product' => $product
    //     ]);
    // }


    // public function show($id)
    // {
    //     $product = Product::with([
    //         'images' => function ($query) {
    //             $query->orderBy('is_main', 'desc')->orderBy('position', 'asc');
    //         },
    //         'categories',
    //         'variants' => function ($query) {
    //             $query->with('images')->where('is_active', true)->where('is_sellable', true);
    //         }
    //     ])
    //         ->where('is_active', true)
    //         ->find($id);

    //     if (!$product) {
    //         abort(404, 'Produk tidak ditemukan atau tidak aktif.');
    //     }

    //     $variant = $product->variants->first();
    //     $priceCents = $variant->price ?? $product->price ?? 0;
    //     $basePrice = round($priceCents);
    //     $subtotal_price = $basePrice * 1;

    //     $productImagesCollection = collect([]);
    //     if ($variant) {
    //         $productImagesCollection = $productImagesCollection->merge($variant->images);
    //     }
    //     $productImagesCollection = $productImagesCollection->merge($product->images)->unique('url')->sortByDesc('is_main');

    //     $mainImageModel = $productImagesCollection->where('is_main', true)->first() ?? $productImagesCollection->first();

    //     $image_be = env('APP_URL_BE');

    //     $product_main_image = $mainImageModel
    //         ? $image_be . ltrim($mainImageModel->url, '/')
    //         : 'https://placehold.co/600x600/ccc/fff?text=No+Image';

    //     $product_images = $productImagesCollection->map(function ($image) {
    //         return [
    //             'url' => env('APP_URL_BE') . ltrim($image->url, '/'),
    //             'label' => 'Gambar Produk',
    //         ];
    //     })->toArray();

    //     // dd($product_images);

    //     $product->average_rating = 0.0;
    //     $product->rating_distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

    //     $category_id = $product->categories->first()->id ?? null;

    //     $related_products = Product::with('images', 'categories')
    //         ->whereHas('categories', function ($query) use ($category_id) {
    //             $query->where('categories.id', $category_id);
    //         })
    //         ->where('id', '!=', $product->id)
    //         ->where('is_active', true)
    //         ->take(4)
    //         ->get();

    //     // dd($related_products);

    //     $products = $related_products->map(function ($p) {
    //         $price_int = round(($p->variants->first()->price ?? $p->price ?? 0));
    //         $old_price_int = round($price_int / 0.8, -3);
    //         $main_img = $p->images->where('is_main', true)->first() ?? $p->images->first();

    //         return [
    //             'id' => $p->id,
    //             'name' => $p->name,
    //             'price' => $price_int,
    //             'category' => $p->categories->first()->name ?? 'Umum',
    //             'rating' => 0.0,
    //             'ulasan' => 0,
    //             'stok' => 'Tersedia',
    //             'url_img' => $main_img ? env('APP_URL_BE') . ltrim($main_img->url, '/') : 'https://placehold.co/400x400/ccc/fff?text=No+Image',
    //             'price_formatted' => number_format($price_int, 0, ',', '.'),
    //             'old_price_formatted' => number_format($old_price_int, 0, ',', '.'),
    //         ];
    //     })->toArray();

    //     // dd( Auth::guard('customer')->user());
    //     // customer location
    //     if (!Auth::guard('customer')->user()) {
    //         $customer_location = [];

    //     } else {
    //         $customer_location = Addresses::where('customer_id', Auth::guard('customer')->user()->id)->get();

    //     }

    //      $branches_available = Inventory::whereHas('variant', function ($query) use ($id) {
    //             $query->where('product_id', $id)->where('available' , '>', 5);
    //         });





    //     return view('frontend.detail', [
    //         'product' => $product,
    //         'product_main_image' => $product_main_image,
    //         'product_images' => $product_images,
    //         'subtotal_price' => $subtotal_price,
    //         'products' => $products,
    //     ]);
    // }


    // public function show($id){
    //     $product = Product::with([
    //         'images' => function ($query) {
    //             $query->orderBy('is_main', 'desc')->orderBy('position', 'asc');
    //         },
    //         'categories',
    //         'variants' => function ($query) {
    //             $query->with('images')->where('is_active', true)->where('is_sellable', true);
    //         }
    //     ])
    //         ->where('is_active', true)
    //         ->find($id);

    //     if (!$product) {
    //         abort(404, 'Produk tidak ditemukan atau tidak aktif.');
    //     }

    //     $variant = $product->variants->first();
    //     $priceCents = $variant->price ?? $product->price ?? 0;
    //     $basePrice = round($priceCents);
    //     $subtotal_price = $basePrice * 1;

    //     $productImagesCollection = collect([]);
    //     if ($variant) {
    //         $productImagesCollection = $productImagesCollection->merge($variant->images);
    //     }
    //     $productImagesCollection = $productImagesCollection->merge($product->images)->unique('url')->sortByDesc('is_main');

    //     $mainImageModel = $productImagesCollection->where('is_main', true)->first() ?? $productImagesCollection->first();

    //     $image_be = env('APP_URL_BE');

    //     $product_main_image = $mainImageModel
    //         ? $image_be . ltrim($mainImageModel->url, '/')
    //         : 'https://placehold.co/600x600/ccc/fff?text=No+Image';

    //     $product_images = $productImagesCollection->map(function ($image) {
    //         return [
    //             'url' => env('APP_URL_BE') . ltrim($image->url, '/'),
    //             'label' => 'Gambar Produk',
    //         ];
    //     })->toArray();

    //     $product->average_rating = 0.0;
    //     $product->rating_distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

    //     $category_id = $product->categories->first()->id ?? null;

    //     $related_products = Product::with('images', 'categories')
    //         ->whereHas('categories', function ($query) use ($category_id) {
    //             $query->where('categories.id', $category_id);
    //         })
    //         ->where('id', '!=', $product->id)
    //         ->where('is_active', true)
    //         ->take(4)
    //         ->get();

    //     $products = $related_products->map(function ($p) {
    //         $price_int = round(($p->variants->first()->price ?? $p->price ?? 0));
    //         $old_price_int = round($price_int / 0.8, -3);
    //         $main_img = $p->images->where('is_main', true)->first() ?? $p->images->first();

    //         return [
    //             'id' => $p->id,
    //             'name' => $p->name,
    //             'price' => $price_int,
    //             'category' => $p->categories->first()->name ?? 'Umum',
    //             'rating' => 0.0,
    //             'ulasan' => 0,
    //             'stok' => 'Tersedia',
    //             'url_img' => $main_img ? env('APP_URL_BE') . ltrim($main_img->url, '/') : 'https://placehold.co/400x400/ccc/fff?text=No+Image',
    //             'price_formatted' => number_format($price_int, 0, ',', '.'),
    //             'old_price_formatted' => number_format($old_price_int, 0, ',', '.'),
    //         ];
    //     })->toArray();

    //     if (Auth::guard('customer')->user()) {
    //         $customer_location = Addresses::where('customer_id', Auth::guard('customer')->user()->id)->get();
    //     } else {
    //         $customer_location = collect([]);
    //     }

    //     $inventoryData = Inventory::with('cabang')
    //         ->whereHas('variant', function ($query) use ($id) {
    //             $query->where('product_id', $id);
    //         })
    //         ->where('available', '>', 0)
    //         ->get()
    //         ->map(function ($inventory) {
    //             return [
    //                 'branch_id' => $inventory->branch_id,
    //                 'branch_name' => $inventory->cabang->name ?? 'Nama Cabang Tidak Ditemukan',
    //                 'branch_address' => $inventory->cabang->address ?? 'Alamat Tidak Ditemukan',
    //                 'available_stock' => $inventory->available,
    //             ];
    //         })
    //         ->groupBy('branch_id')
    //         ->map(function ($groupedItems) {
    //             $firstItem = $groupedItems->first();

    //             $totalAvailable = $groupedItems->sum('available_stock');

    //             return [
    //                 'branch_id' => $firstItem['branch_id'],
    //                 'branch_name' => $firstItem['branch_name'],
    //                 'branch_address' => $firstItem['branch_address'],
    //                 'total_available_stock' => $totalAvailable,
    //                 'status_label' => $totalAvailable > 5 ? 'Stok Banyak' : ($totalAvailable > 0 ? 'Stok Terbatas' : 'Stok Habis'),
    //             ];
    //         })
    //         ->values()
    //         ->toArray();

    //         $default_address = Auth::user()->addresses()->where('is_default', true)->first();

    //     return view('frontend.detail', [
    //         'product' => $product,
    //         'product_main_image' => $product_main_image,
    //         'product_images' => $product_images,
    //         'subtotal_price' => $subtotal_price,
    //         'products' => $products,
    //         'inventory_data' => $inventoryData,
    //     ]);
    // }


    //     private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    //         if (is_null($lat1) || is_null($lon1) || is_null($lat2) || is_null($lon2)) {
    //             return 99999.0; // Nilai default yang sangat tinggi jika koordinat tidak ada
    //         }

    //         $R = 6371; // Radius bumi dalam kilometer
    //         $dLat = deg2rad($lat2 - $lat1);
    //         $dLon = deg2rad($lon2 - $lon1);

    //         $a = sin($dLat / 2) * sin($dLat / 2) +
    //              cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);

    //         $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    //         $distance = $R * $c;

    //         return round($distance, 2); // Jarak dalam km, 2 desimal
    //     }
    // public function show($id){
    //         // 1. Ambil Data Produk
    //         $product = Product::with([
    //             'images' => function ($query) {
    //                 $query->orderBy('is_main', 'desc')->orderBy('position', 'asc');
    //             },
    //             'categories',
    //             'variants' => function ($query) {
    //                 $query->with('images')->where('is_active', true)->where('is_sellable', true);
    //             }
    //         ])
    //             ->where('is_active', true)
    //             ->find($id);

    //         if (!$product) {
    //             abort(404, 'Produk tidak ditemukan atau tidak aktif.');
    //         }

    //         // --- Persiapan Harga & Gambar ---
    //         $variant = $product->variants->first();
    //         $priceCents = $variant->price ?? $product->price ?? 0;
    //         $basePrice = round($priceCents);
    //         $subtotal_price = $basePrice * 1;

    //         // Logika penggabungan gambar produk/varian
    //         $productImagesCollection = collect([]);
    //         if ($variant) {
    //             $productImagesCollection = $productImagesCollection->merge($variant->images);
    //         }
    //         $productImagesCollection = $productImagesCollection->merge($product->images)->unique('url')->sortByDesc('is_main');

    //         $mainImageModel = $productImagesCollection->where('is_main', true)->first() ?? $productImagesCollection->first();

    //         $image_be = env('APP_URL_BE');

    //         $product_main_image = $mainImageModel
    //             ? $image_be . ltrim($mainImageModel->url, '/')
    //             : 'https://placehold.co/600x600/ccc/fff?text=No+Image';

    //         $product_images = $productImagesCollection->map(function ($image) use ($image_be) {
    //             return [
    //                 'url' => $image_be . ltrim($image->url, '/'),
    //                 'label' => 'Gambar Produk',
    //             ];
    //         })->toArray();

    //         // --- Data Ulasan (Simulasi) ---
    //         $product->average_rating = 0.0;
    //         $product->rating_distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

    //         // --- Produk Terkait ---
    //         $category_id = $product->categories->first()->id ?? null;

    //         $related_products = Product::with('images', 'categories', 'variants')
    //             ->whereHas('categories', function ($query) use ($category_id) {
    //                 $query->where('categories.id', $category_id);
    //             })
    //             ->where('id', '!=', $product->id)
    //             ->where('is_active', true)
    //             ->take(4)
    //             ->get();

    //         $products = $related_products->map(function ($p) {
    //             $price_int = round(($p->variants->first()->price ?? $p->price ?? 0));
    //             $old_price_int = round($price_int / 0.8, -3);
    //             $main_img = $p->images->where('is_main', true)->first() ?? $p->images->first();

    //             return [
    //                 'id' => $p->id,
    //                 'name' => $p->name,
    //                 'price' => $price_int,
    //                 'category' => $p->categories->first()->name ?? 'Umum',
    //                 'rating' => 0.0,
    //                 'ulasan' => 0,
    //                 'stok' => 'Tersedia',
    //                 'url_img' => $main_img ? env('APP_URL_BE') . ltrim($main_img->url, '/') : 'https://placehold.co/400x400/ccc/fff?text=No+Image',
    //                 'price_formatted' => number_format($price_int, 0, ',', '.'),
    //                 'old_price_formatted' => number_format($old_price_int, 0, ',', '.'),
    //             ];
    //         })->toArray();

    //         // --- 2. Ambil Lokasi Pelanggan Default (untuk perhitungan jarak) ---
    //         $default_address = null;
    //         if (Auth::guard('customer')->check()) {
    //             $customer_id = Auth::guard('customer')->user()->id;
    //             // Ambil alamat default atau yang pertama
    //             $default_address = Addresses::where('customer_id', $customer_id)
    //                                         ->where('is_default', true)
    //                                         ->orWhere('customer_id', $customer_id)
    //                                         ->orderBy('id', 'desc')
    //                                         ->first();
    //         } 

    //         // Tentukan koordinat pelanggan (digunakan untuk menghitung jarak)
    //         $customer_lat = $default_address ? (float) $default_address->latitude : null;
    //         $customer_lon = $default_address ? (float) $default_address->longitude : null;

    //         // --- 3. Ambil Data Inventori & Cabang ---
    //         $inventoryData = Inventory::with('cabang')
    //             ->whereHas('variant', function ($query) use ($id) {
    //                 $query->where('product_id', $id);
    //             })
    //             ->where('available', '>', 0)
    //             ->get()
    //             ->map(function ($inventory) {
    //                 // Pastikan kolom koordinat ada di model Cabang
    //                 return [
    //                     'branch_id' => $inventory->branch_id,
    //                     'branch_name' => $inventory->cabang->name ?? 'Nama Cabang Tidak Ditemukan',
    //                     'branch_address' => $inventory->cabang->address ?? 'Alamat Tidak Ditemukan',
    //                     'latitude' => (float) $inventory->cabang->latitude, // BARU
    //                     'longitude' => (float) $inventory->cabang->longitude, // BARU
    //                     'available_stock' => $inventory->available,
    //                 ];
    //             })
    //             ->groupBy('branch_id')
    //             ->map(function ($groupedItems) use ($customer_lat, $customer_lon, $default_address) {
    //                 $firstItem = $groupedItems->first();
    //                 $totalAvailable = $groupedItems->sum('available_stock');

    //                 // Tentukan label status dan kelas warna
    //                 if ($totalAvailable > 5) {
    //                     $statusLabel = 'Stok Banyak';
    //                     $statusColor = 'text-green-600'; // Warna Hijau
    //                 } elseif ($totalAvailable > 0) {
    //                     $statusLabel = 'Stok Terbatas';
    //                     $statusColor = 'text-orange-600'; // Warna Oranye
    //                 } else {
    //                     $statusLabel = 'Stok Habis';
    //                     $statusColor = 'text-red-600'; // Warna Merah
    //                 }

    //                 // Perhitungan Jarak (Hanya dilakukan jika pelanggan sudah login dan memiliki koordinat)
    //                 $distance = $this->calculateDistance(
    //                     $customer_lat, 
    //                     $customer_lon, 
    //                     $firstItem['latitude'], 
    //                     $firstItem['longitude']
    //                 );

    //                 $distanceFormatted = ($distance < 99999.0) ? $distance . ' km' : 'Jarak N/A';

    //                 return [
    //                     'branch_id' => $firstItem['branch_id'],
    //                     'branch_name' => $firstItem['branch_name'],
    //                     'branch_address' => $firstItem['branch_address'],
    //                     'latitude' => $firstItem['latitude'], 
    //                     'longitude' => $firstItem['longitude'], 
    //                     'total_available_stock' => $totalAvailable,
    //                     'status_label' => $statusLabel, // Status singkat (misal: Stok Banyak)
    //                     'status_color' => $statusColor, // Kelas warna Tailwind
    //                     'distance_value' => $distance, // Nilai numerik jarak (untuk sorting di JS)
    //                     'distance_formatted' => $distanceFormatted, // Format string jarak (misal: 1.25 km)
    //                 ];
    //             })
    //             ->values()
    //             ->toArray();

    //         // 4. Sortir Cabang Berdasarkan Jarak (di sisi server sebelum dikirim ke view)
    //         usort($inventoryData, function($a, $b) {
    //             // Sortir berdasarkan distance_value
    //             return $a['distance_value'] <=> $b['distance_value'];
    //         });

    //         // 5. Kembalikan View
    //         return view('frontend.detail', [
    //             'product' => $product,
    //             'product_main_image' => $product_main_image,
    //             'product_images' => $product_images,
    //             'subtotal_price' => $subtotal_price,
    //             'products' => $products, // Produk terkait
    //             'inventory_data' => $inventoryData, // Data ketersediaan dan jarak cabang yang sudah diurutkan
    //             'customer_addresses' => $default_address ? Addresses::where('customer_id', $customer_id)->get() : collect([]), // Semua alamat pelanggan (untuk modal)
    //             'default_address' => $default_address, // Alamat default pelanggan (untuk inisialisasi JS)
    //         ]);

    //     }

    // }


    // public function show($id)
    // {
    //     $product = Product::with([
    //         'images' => function ($query) {
    //             $query->orderBy('is_main', 'desc')->orderBy('position', 'asc');
    //         },
    //         'categories',
    //         'variants' => function ($query) {
    //             $query->with('images')->where('is_active', true)->where('is_sellable', true);
    //         }
    //     ])
    //         ->where('is_active', true)
    //         ->find($id);

    //     if (!$product) {
    //         abort(404, 'Produk tidak ditemukan atau tidak aktif.');
    //     }

    //     $variant = $product->variants->first();
    //     $priceCents = $variant->price ?? $product->price ?? 0;
    //     $basePrice = round($priceCents);
    //     $subtotal_price = $basePrice * 1;

    //     $productImagesCollection = collect([]);
    //     if ($variant) {
    //         $productImagesCollection = $productImagesCollection->merge($variant->images);
    //     }
    //     $productImagesCollection = $productImagesCollection->merge($product->images)->unique('url')->sortByDesc('is_main');

    //     $mainImageModel = $productImagesCollection->where('is_main', true)->first() ?? $productImagesCollection->first();

    //     $image_be = env('APP_URL_BE');

    //     $product_main_image = $mainImageModel
    //         ? $image_be . ltrim($mainImageModel->url, '/')
    //         : 'https://placehold.co/600x600/ccc/fff?text=No+Image';

    //     $product_images = $productImagesCollection->map(function ($image) {
    //         return [
    //             'url' => env('APP_URL_BE') . ltrim($image->url, '/'),
    //             'label' => 'Gambar Produk',
    //         ];
    //     })->toArray();

    //     $product->average_rating = 0.0;
    //     $product->rating_distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

    //     $category_id = $product->categories->first()->id ?? null;

    //     // ... (Logika Related Products) ...
    //     $related_products = Product::with('images', 'categories')
    //         ->whereHas('categories', function ($query) use ($category_id) {
    //             $query->where('categories.id', $category_id);
    //         })
    //         ->where('id', '!=', $product->id)
    //         ->where('is_active', true)
    //         ->take(4)
    //         ->get();

    //     $products = $related_products->map(function ($p) {
    //         $price_int = round(($p->variants->first()->price ?? $p->price ?? 0));
    //         $old_price_int = round($price_int / 0.8, -3);
    //         $main_img = $p->images->where('is_main', true)->first() ?? $p->images->first();

    //         return [
    //             'id' => $p->id,
    //             'name' => $p->name,
    //             'price' => $price_int,
    //             'category' => $p->categories->first()->name ?? 'Umum',
    //             'rating' => 0.0,
    //             'ulasan' => 0,
    //             'stok' => 'Tersedia',
    //             'url_img' => $main_img ? env('APP_URL_BE') . ltrim($main_img->url, '/') : 'https://placehold.co/400x400/ccc/fff?text=No+Image',
    //             'price_formatted' => number_format($price_int, 0, ',', '.'),
    //             'old_price_formatted' => number_format($old_price_int, 0, ',', '.'),
    //         ];
    //     })->toArray();

    //     // 1. Ambil Data Alamat Pelanggan
    //     $customer_locations =  [];
    //     $default_address = null;

    //     if (Auth::guard('customer')->check()) {
    //         $customer = Auth::guard('customer')->user();
    //         // ASUMSI: Model Addresses di-relasikan dengan Customer
    //         $customer_locations = $customer->addresses()->get();

    //         // Pastikan Anda mendapatkan alamat default yang akan digunakan untuk inisialisasi JS
    //         $default_address = $customer_locations->where('is_default', true)->first();
    //     }
    //     // Jika tidak login, default_address tetap null

    //     // 2. Ambil Data Inventory DENGAN data lokasi Cabang
    //     $inventoryData = Inventory::with(['variant', 'cabang'])
    //         ->whereHas('variant', function ($query) use ($id) {
    //             $query->where('product_id', $id);
    //         })
    //         ->where('available', '>', 0)
    //         ->get()
    //         ->map(function ($inventory) {
    //             $cabang = $inventory->cabang;
    //             $status_label = $inventory->available > 5 ? 'Stok Banyak' : ($inventory->available > 0 ? 'Stok Terbatas' : 'Stok Habis');
    //             $status_color = $inventory->available > 5 ? 'text-green-600' : ($inventory->available > 0 ? 'text-orange-500' : 'text-red-500');

    //             return [
    //                 'branch_id' => $inventory->branch_id,
    //                 'branch_name' => $cabang->name ?? 'Nama Cabang N/A',
    //                 'branch_address' => $cabang->address ?? 'Alamat N/A',
    //                 'latitude' => $cabang->latitude ?? 0, // PASTIKAN ADA kolom 'latitude' di model Cabang
    //                 'longitude' => $cabang->longitude ?? 0, // PASTIKAN ADA kolom 'longitude' di model Cabang
    //                 'total_available_stock' => $inventory->available,
    //                 'status_label' => $status_label,
    //                 'status_color_class' => $status_color,
    //             ];
    //         })
    //         ->groupBy('branch_id')
    //         ->map(function ($groupedItems) {
    //             // Kita ambil data cabang dari item pertama (karena semua harusnya sama)
    //             $firstItem = $groupedItems->first();
    //             $totalAvailable = $groupedItems->sum('total_available_stock');

    //             // Kita harus update statusnya lagi jika total stok lebih dari 5
    //             $status_label = $totalAvailable > 5 ? 'Stok Banyak' : ($totalAvailable > 0 ? 'Stok Terbatas' : 'Stok Habis');
    //             $status_color = $totalAvailable > 5 ? 'text-green-600' : ($totalAvailable > 0 ? 'text-orange-500' : 'text-red-500');

    //             return [
    //                 'branch_id' => $firstItem['branch_id'],
    //                 'branch_name' => $firstItem['branch_name'],
    //                 'branch_address' => $firstItem['branch_address'],
    //                 'latitude' => $firstItem['latitude'],
    //                 'longitude' => $firstItem['longitude'],
    //                 'total_available_stock' => $totalAvailable,
    //                 'status_label' => $status_label,
    //                 'status_color_class' => $status_color,
    //             ];
    //         })
    //         ->values()
    //         ->toArray();

    //     // dd($customer_locations);


    //     // 3. Kirim data yang dibutuhkan ke View
    //     return view('frontend.detail', [
    //         'product' => $product,
    //         'product_main_image' => $product_main_image,
    //         'product_images' => $product_images,
    //         'subtotal_price' => $subtotal_price,
    //         'products' => $products,
    //         'inventory_data' => $inventoryData, // Data Cabang dengan Lat/Lon
    //         'default_address' => $default_address, // Alamat Default Pelanggan (untuk inisialisasi JS)
    //         'customer_addresses' => $customer_locations, // SEMUA Alamat Pelanggan (untuk modal)
    //     ]);
    // }


    private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2) {
        // Radius bumi dalam kilometer
        $earthRadius = 6371; 

        // Konversi derajat ke radian
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        // Rumus Haversine
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + 
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
            
        return $angle * $earthRadius;
    }

    public function show($id)
    {
        $product = Product::with([
            'images' => function ($query) {
                $query->orderBy('is_main', 'desc')->orderBy('position', 'asc');
            },
            'categories',
            'variants' => function ($query) {
                $query->with('images')->where('is_active', true)->where('is_sellable', true);
            }
        ])
            ->where('is_active', true)
            ->find($id);

        if (!$product) {
            abort(404, 'Produk tidak ditemukan atau tidak aktif.');
        }

        $variant = $product->variants->first();
        $priceCents = $variant->price ?? $product->price ?? 0;
        $basePrice = round($priceCents);
        $subtotal_price = $basePrice * 1;

        // --- Logika Gambar (Tidak Berubah Signifikan) ---
        $productImagesCollection = collect([]);
        if ($variant) {
            $productImagesCollection = $productImagesCollection->merge($variant->images);
        }
        $productImagesCollection = $productImagesCollection->merge($product->images)->unique('url')->sortByDesc('is_main');

        $mainImageModel = $productImagesCollection->where('is_main', true)->first() ?? $productImagesCollection->first();

        $image_be = env('APP_URL_BE');

        $product_main_image = $mainImageModel
            ? $image_be . ltrim($mainImageModel->url, '/')
            : 'https://placehold.co/600x600/ccc/fff?text=No+Image';

        $product_images = $productImagesCollection->map(function ($image) {
            return [
                'url' => env('APP_URL_BE') . ltrim($image->url, '/'),
                'label' => 'Gambar Produk',
            ];
        })->toArray();
        
        $product->average_rating = 0.0;
        $product->rating_distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        
        // --- Logika Related Products (Tidak Berubah) ---
        $category_id = $product->categories->first()->id ?? null;
        $related_products = Product::with('images', 'categories')
            ->whereHas('categories', function ($query) use ($category_id) {
                $query->where('categories.id', $category_id);
            })
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        $products = $related_products->map(function ($p) {
            $price_int = round(($p->variants->first()->price ?? $p->price ?? 0));
            $old_price_int = round($price_int / 0.8, -3);
            $main_img = $p->images->where('is_main', true)->first() ?? $p->images->first();

            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $price_int,
                'category' => $p->categories->first()->name ?? 'Umum',
                'rating' => 0.0,
                'ulasan' => 0,
                'stok' => 'Tersedia',
                'url_img' => $main_img ? env('APP_URL_BE') . ltrim($main_img->url, '/') : 'https://placehold.co/400x400/ccc/fff?text=No+Image',
                'price_formatted' => number_format($price_int, 0, ',', '.'),
                'old_price_formatted' => number_format($old_price_int, 0, ',', '.'),
            ];
        })->toArray();

        // 1. Ambil Data Alamat Pelanggan
        $customer_locations = [];
        $default_address = null;
        $customerLat = 0;
        $customerLon = 0;

        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            // ASUMSI: Model Addresses di-relasikan dengan Customer
            $customer_locations = $customer->addresses()->get();

            // Ambil alamat default untuk koordinat
            $default_address = $customer_locations->where('is_default', true)->first();
            
            if ($default_address) {
                // PASTIKAN kolom 'latitude' dan 'longitude' ADA di Model Address
                $customerLat = (float) $default_address->latitude ?? 0; 
                $customerLon = (float) $default_address->longitude ?? 0;
            }
        }
        
        // 2. Ambil Data Inventory, Cabang, dan Hitung Jarak
        $inventoryData = Inventory::with(['variant', 'cabang'])
            ->whereHas('variant', function ($query) use ($id) {
                $query->where('product_id', $id);
            })
            ->where('available', '>', 0)
            ->get()
            ->map(function ($inventory) use ($customerLat, $customerLon) {
                $cabang = $inventory->cabang;
                $status_label = $inventory->available > 5 ? 'Stok Banyak' : ($inventory->available > 0 ? 'Stok Terbatas' : 'Stok Habis');
                $status_color = $inventory->available > 5 ? 'text-green-600' : ($inventory->available > 0 ? 'text-orange-500' : 'text-red-500');
                
                $branchLat = (float) $cabang->latitude ?? 0;
                $branchLon = (float) $cabang->longitude ?? 0;
                
                // Hitung Jarak
                $distanceKm = 0;
                $distanceDisplay = 'N/A';
                
                if ($customerLat != 0 && $customerLon != 0 && $branchLat != 0 && $branchLon != 0) {
                    $distanceKm = $this->calculateHaversineDistance($customerLat, $customerLon, $branchLat, $branchLon);
                    $distanceDisplay = number_format($distanceKm, 2, ',', '.') . ' km';
                }
                
                return [
                    'branch_id' => $inventory->branch_id,
                    'branch_name' => $cabang->name ?? 'Nama Cabang N/A',
                    'branch_address' => $cabang->address ?? 'Alamat N/A',
                    'distance_value' => $distanceKm, // Nilai numerik untuk sorting
                    'distance_display' => $distanceDisplay, // Nilai string untuk ditampilkan
                    'latitude' => $branchLat, 
                    'longitude' => $branchLon, 
                    'total_available_stock' => $inventory->available,
                    'status_label' => $status_label,
                    'status_color_class' => $status_color,
                ];
            })
            ->groupBy('branch_id')
            ->map(function ($groupedItems) {
                // Kita ambil data cabang dari item pertama (karena semua harusnya sama)
                $firstItem = $groupedItems->first();
                $totalAvailable = $groupedItems->sum('total_available_stock');

                // Kita harus update statusnya lagi jika total stok lebih dari 5
                $status_label = $totalAvailable > 5 ? 'Stok Tersedia' : ($totalAvailable > 0 ? 'Stok Terbatas' : 'Stok Habis');
                $status_color = $totalAvailable > 5 ? 'text-green-600' : ($totalAvailable > 0 ? 'text-orange-500' : 'text-red-500');

                return [
                    'branch_id' => $firstItem['branch_id'],
                    'branch_name' => $firstItem['branch_name'],
                    'branch_address' => $firstItem['branch_address'],
                    'distance_value' => $firstItem['distance_value'], // Pertahankan nilai jarak numerik
                    'distance_display' => $firstItem['distance_display'], // Pertahankan nilai jarak tampilan
                    'latitude' => $firstItem['latitude'],
                    'longitude' => $firstItem['longitude'],
                    'total_available_stock' => $totalAvailable,
                    'status_label' => $status_label,
                    'status_color_class' => $status_color,
                ];
            })
            ->sortBy('distance_value') // SORTIR DI CONTROLLER BERDASARKAN JARAK
            ->values()
            ->toArray();


        // 3. Kirim data yang dibutuhkan ke View
        return view('frontend.detail', [
            'product' => $product,
            'product_main_image' => $product_main_image,
            'product_images' => $product_images,
            'subtotal_price' => $subtotal_price,
            'products' => $products,
            'inventory_data' => $inventoryData, 
            'default_address' => $default_address, 
            'customer_addresses' => $customer_locations, 
        ]);
    }
}
