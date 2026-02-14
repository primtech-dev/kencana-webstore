<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Branches;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $defaultEagerLoads = ['images', 'categories', 'variants', 'variants.images'];


    public function index(Request $request)
    {
        $branches = Branches::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        $home_banner = HomeBanner::where('is_active', true)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->get();

        return view('frontend.index', [
            'categories' => $categories,
            'branches' => $branches,
            'home_banner' => $home_banner,
            'selectedCategory' => $request->get('category'),
        ]);
    }

    public function productJson(Request $request)
    {
        $categorySlug = $request->get('category');
        $selectedBranchId = session('selected_branch_id');

        $productsQuery = Product::query()->where('is_active', true);

        // Filter Cabang
        if ($selectedBranchId) {
            $productsQuery->whereHas('variants.inventories.cabang', function ($q) use ($selectedBranchId) {
                $q->where('branch_id', $selectedBranchId)->where('available', '>', 0);
            });
        }

        // Di Controller, pastikan trim search-nya
        $search = trim($request->get('search'));

        // Filter Search (Case-Insensitive)
        $productsQuery->when($search, function ($query, $search) {
            // Ubah kata kunci menjadi huruf kecil
            $loweredSearch = strtolower($search);

            $query->where(function ($sub) use ($loweredSearch) {
                $sub->whereRaw('LOWER(name) like ?', ["%{$loweredSearch}%"])
                    ->orWhereRaw('LOWER(sku) like ?', ["%{$loweredSearch}%"]);
            });
        });

        // Filter Kategori
        $productsQuery->when($categorySlug, function ($query, $categorySlug) {
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        });
        // Eager Load & Paginate
        $products = $productsQuery->with([
            'images',
            'categories',
            'variants.inventories' => function ($q) use ($selectedBranchId) {
                // Filter stok inventori sesuai cabang yang dipilih
                if ($selectedBranchId) {
                    $q->where('branch_id', $selectedBranchId);
                }
            },
            'reviews' // Ambil semua review agar rating muncul meski ganti cabang
        ])->paginate(12);

        return response()->json($products);
    }


    private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2)
    {
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
        // 2. Ambil Data Inventory, Cabang, dan Hitung Jarak
        $inventoryData = Inventory::with(['variant', 'cabang'])
            ->whereHas('variant', function ($query) use ($id) {
                $query->where('product_id', $id);
            })
            ->where('available', '>', 0)
            ->get()
            ->map(function ($inventory) use ($customerLat, $customerLon) {
                $cabang = $inventory->cabang;
                $variant = $inventory->variant; // Ambil object variant

                $branchLat = (float) ($cabang->latitude ?? 0);
                $branchLon = (float) ($cabang->longitude ?? 0);

                // Hitung Jarak
                $distanceKm = 0;
                $distanceDisplay = 'N/A';
                if ($customerLat != 0 && $customerLon != 0 && $branchLat != 0 && $branchLon != 0) {
                    $distanceKm = $this->calculateHaversineDistance($customerLat, $customerLon, $branchLat, $branchLon);
                    $distanceDisplay = number_format($distanceKm, 2, ',', '.') . ' km';
                }

                return [
                    'variant_id' => $variant->id, // TAMBAHKAN INI
                    'variant_name' => $variant->name, // Opsional: misal "Warna Merah, Ukuran XL"
                    'sku' => $variant->sku,
                    'branch_id' => $inventory->branch_id,
                    'branch_name' => $cabang->name ?? 'Nama Cabang N/A',
                    'branch_address' => $cabang->address ?? 'Alamat N/A',
                    'distance_value' => $distanceKm,
                    'distance_display' => $distanceDisplay,
                    'latitude' => $branchLat,
                    'longitude' => $branchLon,
                    'available_stock' => $inventory->available,
                ];
            })
            ->groupBy('branch_id')
            ->map(function ($groupedItems) {
                $firstItem = $groupedItems->first();
                $totalAvailable = $groupedItems->sum('available_stock');

                $status_label = $totalAvailable > 5 ? 'Stok Tersedia' : ($totalAvailable > 0 ? 'Stok Terbatas' : 'Stok Habis');
                $status_color = $totalAvailable > 5 ? 'text-green-600' : ($totalAvailable > 0 ? 'text-orange-500' : 'text-red-500');

                return [
                    'branch_id' => $firstItem['branch_id'],
                    'branch_name' => $firstItem['branch_name'],
                    'branch_address' => $firstItem['branch_address'],
                    'distance_value' => $firstItem['distance_value'],
                    'distance_display' => $firstItem['distance_display'],
                    'latitude' => $firstItem['latitude'],
                    'longitude' => $firstItem['longitude'],
                    'total_available_stock' => $totalAvailable,
                    'status_label' => $status_label,
                    'status_color_class' => $status_color,
                    // 'items' sekarang berisi daftar varian yang tersedia di cabang tersebut
                    'items' => $groupedItems->map(function ($item) {
                        return [
                            'variant_id' => $item['variant_id'],
                            'sku' => $item['sku'],
                            'variant_name' => $item['variant_name'],
                            'stock' => $item['available_stock']
                        ];
                    })->toArray(),
                ];
            })
            ->sortBy('distance_value')
            ->values()
            ->toArray();

        $reviews = Reviews::where('product_id', $id)
            ->where('status', 'published')
            ->with('customer', 'product', 'images')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Hitung rata-rata ulasan secara manual dari database
        $averageRating = Reviews::where('product_id', $id)
            ->where('status', 'published')
            ->avg('rating') ?? 0;

        // 3. Kirim data yang dibutuhkan ke View
        return view('frontend.detail', [
            'product' => $product,
            'product_main_image' => $product_main_image,
            'reviews' => $reviews,
            'product_images' => $product_images,
            'subtotal_price' => $subtotal_price,
            'products' => $products,
            'inventory_data' => $inventoryData,
            'default_address' => $default_address,
            'customer_addresses' => $customer_locations,
            'averageRating' => $averageRating
        ]);
    }

    public function setBranch(Request $request)
    {
        // Validasi input
        $request->validate([
            'branch_id' => 'required|exists:branches,id', // Pastikan ID cabang ada
        ]);

        // Simpan ID Cabang ke Session
        session(['selected_branch_id' => $request->branch_id]);

        return redirect()->route('products.index')
            ->with('branch_set', 'Cabang toko Anda berhasil dipilih!');
    }

    // public function getNearbyBranches(Request $request)
    // {
    //     // 1. Validasi input koordinat user
    //     $request->validate([
    //         'user_lat' => 'required|numeric|between:-90,90',
    //         'user_lon' => 'required|numeric|between:-180,180',
    //     ]);

    //     $userLat = $request->user_lat;
    //     $userLon = $request->user_lon;

    //     // Jari-jari Bumi (dalam kilometer)
    //     $earthRadius = 6371;

    //     // 2. Query Cabang dengan Perhitungan Jarak (Rumus Haversine)
    //     $branches = Branches::select('*', DB::raw("
    //         ({$earthRadius} * acos(
    //             cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))
    //         )) AS distance
    //     "))
    //         // Ganti 'latitude' dan 'longitude' dengan nama kolom yang benar di tabel branches Anda
    //         ->setBindings([$userLat, $userLon, $userLat])
    //         ->orderBy('distance', 'asc') // Urutkan dari yang terdekat
    //         ->get();

    //     // 3. Mengembalikan data dalam format JSON
    //     return response()->json([
    //         'status' => 'success',
    //         'user_location' => ['lat' => $userLat, 'lon' => $userLon],
    //         'branches' => $branches
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     $search = $request->get('search');
    //     $categorySlug = $request->get('category'); // Ambil parameter kategori dari URL

    //     // 1. Dapatkan ID Cabang dari Session
    //     $selectedBranchId = session('selected_branch_id');

    //     // 2. Mengambil Data Cabang & Kategori untuk Filter di View
    //     $branches = Branches::where('is_active', true)->get();
    //     $categories = Category::where('is_active', true)->get(); // Mengambil data kategori

    //     // 3. Membangun Query Produk
    //     $productsQuery = Product::query()
    //         ->where('is_active', true);

    //     // 4. Filter Berdasarkan Cabang yang Dipilih
    //     if ($selectedBranchId) {
    //         $productsQuery->whereHas('variants', function ($queryVariant) use ($selectedBranchId) {
    //             $queryVariant->whereHas('inventories', function ($queryInventory) use ($selectedBranchId) {
    //                 $queryInventory->whereHas('cabang', function ($queryCabang) use ($selectedBranchId) {
    //                     $queryCabang->where('branch_id', $selectedBranchId);
    //                 })
    //                     ->where('available', '>', 0);
    //             });
    //         });
    //     }

    //     // 5. Filter Pencarian (Nama/SKU)
    //     $productsQuery->when($search, function ($query, $search) {
    //         $query->where(function ($subQuery) use ($search) {
    //             $subQuery->where('name', 'like', '%' . $search . '%')
    //                 ->orWhere('sku', 'like', '%' . $search . '%');
    //         });
    //     });

    //     // 6. BARU: Filter Berdasarkan Kategori
    //     $productsQuery->when($categorySlug, function ($query, $categorySlug) {
    //         $query->whereHas('categories', function ($q) use ($categorySlug) {
    //             $q->where('slug', $categorySlug); // Atau gunakan 'id' tergantung kebutuhan
    //         });
    //     });

    //     // 7. Eager Load dengan Kondisi Cabang
    //     $products = $productsQuery->with(['images', 'categories', 'variants' => function ($q) use ($selectedBranchId) {
    //         $q->with(['inventories' => function ($inv) use ($selectedBranchId) {
    //             if ($selectedBranchId) {
    //                 $inv->whereHas('cabang', function ($c) use ($selectedBranchId) {
    //                     $c->where('branch_id', $selectedBranchId);
    //                 });
    //             }
    //         }]);
    //     }])->paginate(12);

    //     $branchesForJs = $branches->map(function ($branch) {
    //         return [
    //             'id' => $branch->id,
    //             'name' => $branch->name,
    //             'lat' => $branch->latitude,
    //             'lon' => $branch->longitude,
    //         ];
    //     })->all();

    //     $home_banner = HomeBanner::where('is_active', true)->where('start_at', '<=', now())->where('end_at', '>=', now())->first() ?? null;

    //     // 8. Mengembalikan View Blade dengan tambahan variable 'categories'
    //     return view('frontend.index', [
    //         'products' => $products,
    //         'search' => $search,
    //         'categories' => $categories, // Dikirim ke blade
    //         'selectedCategory' => $categorySlug, // Untuk menandai kategori yang aktif
    //         'branches' => $branches,
    //         'selectedBranchId' => $selectedBranchId,
    //         'branchesForJs' => $branchesForJs,
    //         'home_banner' => $home_banner,
    //     ]);
    // }
}
