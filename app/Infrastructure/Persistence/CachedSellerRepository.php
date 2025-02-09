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
    private const CACHE_TTL = 1200;

    /**
     * @param EloquentSellerRepository $repository
     */
    public function __construct(private readonly EloquentSellerRepository $repository)
    {
    }

    /**
     * @param string $id
     * @return Seller|null
     */
    public function findById(string $id): ?Seller
    {
        return Cache::remember(self::CACHE_KEY_PREFIX . $id, self::CACHE_TTL, function () use ($id) {
            return $this->repository->findById($id);
        });
    }

    /**
     * @param Seller $seller
     * @return Seller
     */
    public function save(Seller $seller): Seller
    {
        $savedSeller = $this->repository->save($seller);
        $cached = Cache::get('sellers_all');
        $sellers = $cached ? json_decode($cached, true) : [];

        $sellers[] = [
            'id' => $seller->getId(),
            'name' => $seller->getName(),
            'email' => $seller->getEmail()
        ];

        Cache::put('sellers_all', json_encode($sellers), self::CACHE_TTL);
        return $savedSeller;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $cached = Cache::get('sellers_all');

        if ($cached) {
            $decoded = json_decode($cached, true) ?? [];

            return array_map(
                fn ($seller) => new Seller(
                    id: $seller['id'],
                    name: $seller['name'],
                    email: $seller['email']
                ),
                $decoded
            );
        }

        $sellers = $this->repository->findAll();

        if (!empty($sellers)) {
            $sellersArray = array_map(fn ($seller) => [
                'id' => $seller->getId(),
                'name' => $seller->getName(),
                'email' => $seller->getEmail()
            ], $sellers);

            Cache::put('sellers_all', json_encode($sellersArray), self::CACHE_TTL);
        }

        return $sellers;
    }
}
