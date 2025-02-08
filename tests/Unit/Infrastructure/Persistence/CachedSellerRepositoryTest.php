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
        $seller = new Seller(1, 'Fulano Tal', 'fulano@example.com');
        Cache::shouldReceive('remember')
            ->once()
            ->with('seller_fulano@example.com', 600, \Closure::class)
            ->andReturn($seller);

        $result = $this->cachedSellerRepository->findByEmail('fulano@example.com');

        $this->assertEquals($seller, $result);
    }

    public function testSaveStoreSellerCache(): void
    {
        $seller = new Seller(1, 'Fulano Tal', 'fulano@example.com');

        $this->eloquentSellerRepository
            ->expects($this->once())
            ->method('save')
            ->with($seller)
            ->willReturn($seller);

        Cache::shouldReceive('put')
            ->once()
            ->with('seller_fulano@example.com', $seller, 600);

        $result = $this->cachedSellerRepository->save($seller);

        $this->assertEquals($seller, $result);
    }
}
