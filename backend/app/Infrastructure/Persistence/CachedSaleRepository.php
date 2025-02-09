<?php

namespace Infrastructure\Persistence;

use Carbon\Carbon;
use Domain\Entities\Sale;
use Domain\Repositories\SaleRepositoryInterface;
use Illuminate\Support\Facades\Cache;

/**
 * Implementation of the sale repository with caching using Redis.
 */
class CachedSaleRepository implements SaleRepositoryInterface
{
    private const CACHE_KEY_PREFIX = 'sale_';
    private const CACHE_TTL = 1200;

    /**
     * @param EloquentSaleRepository $repository
     */
    public function __construct(private readonly EloquentSaleRepository $repository)
    {
    }

    /**
     * @param int $sellerId
     * @param Carbon|null $date
     * @return array
     */
    public function findBySellerId(int $sellerId, ?Carbon $date = null): array
    {
        $cacheKey = $date ? "sales_{$sellerId}_{$date->toDateString()}" : "sales_{$sellerId}_all";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($sellerId, $date) {
            return $this->repository->findBySellerId($sellerId, $date);
        });
    }


    /**
     * @param Sale $sale
     * @return Sale
     */
    public function save(Sale $sale): Sale
    {
        $savedSale = $this->repository->save($sale);
        Cache::put(self::CACHE_KEY_PREFIX . $savedSale->getId(), $savedSale, self::CACHE_TTL);
        return $savedSale;
    }
}
