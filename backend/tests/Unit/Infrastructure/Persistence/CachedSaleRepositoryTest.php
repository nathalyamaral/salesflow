<?php

namespace Tests\Unit\Infrastructure\Persistence;

use Carbon\Carbon;
use DateTime;
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
        $this->cachedSaleRepository = new CachedSaleRepository(repository: $this->eloquentSaleRepository);
    }

    public function testFindBySellerIdCachedSales(): void
    {
        $seller = new Seller(
            id: 1,
            name: 'Fulano Tal',
            email: 'fulano@example.com'
        );
        $sale = new Sale(
            id: 1,
            seller: $seller,
            amount: 500.0,
            commission: $seller->getCommission(),
            date: new DateTime('2024-02-07')
        );

        $testDate = new DateTime('2024-02-07');
        $cacheKeyWithDate = "sales_1_" . $testDate->format('Y-m-d');

        Cache::shouldReceive('remember')
            ->once()
            ->with($cacheKeyWithDate, 1200, \Closure::class)
            ->andReturn([$sale]);

        $result = $this->cachedSaleRepository->findBySellerId(1, Carbon::parse($testDate->format('Y-m-d')));

        $this->assertEquals([$sale], $result);
    }

    public function testCachedStoreSale(): void
    {
        $seller = new Seller(
            id: 1,
            name: 'Fulano Tal',
            email: 'fulano@example.com'
        );
        $sale = new Sale(
            id: 1,
            seller: $seller,
            amount: 500.0,
            commission: $seller->getCommission(),
            date: new DateTime('2024-02-07')
        );

        $this->eloquentSaleRepository
            ->expects($this->once())
            ->method('save')
            ->with($sale)
            ->willReturn($sale);

        Cache::shouldReceive('put')
            ->once()
            ->with('sale_1', $sale, 1200);

        $result = $this->cachedSaleRepository->save($sale);

        $this->assertEquals($sale, $result);
    }
}
