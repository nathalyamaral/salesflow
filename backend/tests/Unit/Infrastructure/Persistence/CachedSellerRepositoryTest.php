<?php

namespace Tests\Unit\Infrastructure\Persistence;

use Domain\Entities\Seller;
use Infrastructure\Persistence\CachedSellerRepository;
use Infrastructure\Persistence\EloquentSellerRepository;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CachedSellerRepositoryTest extends TestCase
{
    private CachedSellerRepository $cachedSellerRepository;
    private EloquentSellerRepository $eloquentSellerRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eloquentSellerRepository = $this->createMock(EloquentSellerRepository::class);
        $this->cachedSellerRepository = new CachedSellerRepository($this->eloquentSellerRepository);
    }

    public function testFindByEmaiCachedSeller(): void
    {
        $seller = new Seller(
            id: 1,
            name: 'Fulano Tal',
            email: 'fulano@example.com'
        );

        Cache::shouldReceive('remember')
            ->once()
            ->withArgs(function ($key, $ttl, $callback) {
                return $key === 'seller_1' && $ttl === 1200 && is_callable($callback);
            })
            ->andReturn($seller);

        $result = $this->cachedSellerRepository->findById(1);

        $this->assertEquals($seller, $result);
    }
}
