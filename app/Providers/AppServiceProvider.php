<?php

namespace App\Providers;

use App\Infrastructure\Persistence\CachedSellerRepository;
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
        $this->app->bind(SellerRepositoryInterface::class, EloquentSellerRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, EloquentSaleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
