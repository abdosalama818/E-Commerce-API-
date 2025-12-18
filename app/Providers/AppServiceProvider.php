<?php

namespace App\Providers;

use App\Interface\ProductInterface;
use App\Repository\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
     $this->app->bind(ProductInterface::class, ProductRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
