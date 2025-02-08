<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Seller;
use Domain\Repositories\SellerRepositoryInterface;
use Illuminate\Support\Facades\Cache;

/**
 * Implementation of the seller repository with caching using Redis.
 */
class CachedSellerRepository implements SellerRepositoryInterface
{
    private const CACHE_KEY_PREFIX = 'seller_';
    private const CACHE_TTL = 600;

    /**
     * @param EloquentSellerRepository $repository
     */
    public function __construct(private readonly EloquentSellerRepository $repository)
    {
    }

    /**
     * @param string $email
     * @return Seller|null
     */
    public function findByEmail(string $email): ?Seller
    {
        return Cache::remember(self::CACHE_KEY_PREFIX . $email, self::CACHE_TTL, function () use ($email) {
            return $this->repository->findByEmail($email);
        });
    }

    /**
     * @param Seller $seller
     * @return Seller
     */
    public function save(Seller $seller): Seller
    {
        $savedSeller = $this->repository->save($seller);
        Cache::put(self::CACHE_KEY_PREFIX . $savedSeller->getEmail(), $savedSeller, self::CACHE_TTL);
        return $savedSeller;
    }
}
