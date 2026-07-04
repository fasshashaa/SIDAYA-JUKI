<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Keranjang; 
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         View::composer('layouts.marketplace', function ($view) {
        $cartCount = auth()->check()
            ? Keranjang::where('user_id', auth()->id())->sum('jumlah')
            : 0;

        $view->with('cartCount', $cartCount);
    });
    }
}
