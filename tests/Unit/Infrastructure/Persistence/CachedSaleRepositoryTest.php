<?php

namespace Tests\Unit\Infrastructure\Persistence;

use Domain\Entities\Sale;
use Domain\Entities\Seller;
use Infrastructure\Persistence\CachedSaleRepository;
use Infrastructure\Persistence\EloquentSaleRepository;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CachedSaleRepositoryTest extends TestCase
{
    private CachedSaleRepository $cachedSaleRepository;
    private EloquentSaleRepository $eloquentSaleRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eloquentSaleRepository = $this->createMock(EloquentSaleRepository::class);
        $this->cachedSaleRepository = new CachedSaleRepository($this->eloquentSaleRepository);
    }

    public function testFindBySellerIdCachedSales(): void
    {
        $seller = new Seller(1, 'Fulano Tal', 'fulano@example.com');
        $sale = new Sale(1, $seller, 500.0, 50.0, now());
        Cache::shouldReceive('remember')
            ->once()
            ->with('sale_1', 600, \Closure::class)
            ->andReturn([$sale]);

        $result = $this->cachedSaleRepository->findBySellerId(1);

        $this->assertEquals([$sale], $result);
    }

    public function testCachedStoreSale(): void
    {
        $seller = new Seller(1, 'Fulano Tal', 'fulano@example.com');
        $sale = new Sale(1, $seller, 500.0, 50.0, now());

        $this->eloquentSaleRepository
            ->expects($this->once())
            ->method('save')
            ->with($sale)
            ->willReturn($sale);

        Cache::shouldReceive('put')
            ->once()
            ->with('sale_1', $sale, 600);

        $result = $this->cachedSaleRepository->save($sale);

        $this->assertEquals($sale, $result);
    }
}
