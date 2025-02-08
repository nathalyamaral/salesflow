<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Sale;
use Domain\Repositories\SaleRepositoryInterface;
use Illuminate\Support\Facades\Cache;

/**
 * Implementation of the sale repository with caching using Redis.
 */
class CachedSaleRepository implements SaleRepositoryInterface
{
    private const CACHE_KEY_PREFIX = 'sale_';
    private const CACHE_TTL = 600;

    /**
     * @param EloquentSaleRepository $repository
     */
    public function __construct(private readonly EloquentSaleRepository $repository)
    {
    }

    /**
     * @param int $sellerId
     * @return array
     */
    public function findBySellerId(int $sellerId): array
    {
        $sales = Cache::remember(self::CACHE_KEY_PREFIX . $sellerId, self::CACHE_TTL, function () use ($sellerId) {
            $result = $this->repository->findBySellerId($sellerId);
            return is_array($result) ? $result : [$result];
        });

        return is_array($sales) ? $sales : [$sales]; // ✅ Se o cache retornou um objeto único, transforma em array
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
