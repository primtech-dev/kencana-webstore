<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Carts;

class CartInfoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('frontend.components.header', function ($view) {
            
            $cartCount = 0;

            if (Auth::guard('customer')->user()) {
                $user = Auth::guard('customer')->user();
                $cart = Carts::where('customer_id', $user->id)        
                            ->get();
                if (count($cart) > 0) {

                    foreach ($cart as $item) {
                        $cartCount += count($item->items);
                    }
                    
                }else{
                    $cartCount = 0;
                }
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
