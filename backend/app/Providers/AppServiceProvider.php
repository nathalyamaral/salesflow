<?php

namespace App\Providers;

use Infrastructure\Persistence\CachedSaleRepository;
use Infrastructure\Persistence\CachedSellerRepository;
use Illuminate\Support\ServiceProvider;
use Domain\Repositories\SellerRepositoryInterface;
use Domain\Repositories\SaleRepositoryInterface;
use Infrastructure\Persistence\EloquentSellerRepository;
use Infrastructure\Persistence\EloquentSaleRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SellerRepositoryInterface::class, function ($app) {
            return new CachedSellerRepository(new EloquentSellerRepository());
        });
        $this->app->bind(SaleRepositoryInterface::class, function ($app) {
            return new CachedSaleRepository(new EloquentSaleRepository());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
