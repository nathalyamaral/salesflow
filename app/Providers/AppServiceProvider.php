<?php

namespace App\Providers;

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
