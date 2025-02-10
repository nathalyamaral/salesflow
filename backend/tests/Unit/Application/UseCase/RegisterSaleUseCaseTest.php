<?php

namespace Tests\Unit\Application\UseCase;

use Application\UseCases\RegisterSaleUseCase;
use DateTime;
use Domain\Entities\Sale;
use Domain\Entities\Seller;
use Domain\Repositories\SaleRepositoryInterface;
use Domain\Repositories\SellerRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for RegisterSaleUseCase.
 */
class RegisterSaleUseCaseTest extends TestCase
{
    public function testRegisterSale(): void
    {
        $seller = new Seller(
            id: 1,
            name: 'Fulano Tal',
            email: 'fulano@example.com'
        );

        $sellerRepository = $this->createMock(SellerRepositoryInterface::class);
        $sellerRepository->method('findById')->willReturn($seller);

        $saleRepository = $this->createMock(SaleRepositoryInterface::class);
        $saleRepository->expects($this->once())
            ->method('save')
            ->willReturn(
                new Sale(id: 1,
                    seller: $seller,
                    amount: 500.0,
                    commission: 42.5,
                    date: new DateTime('2024-02-07')
                )
            );

        $useCase = new RegisterSaleUseCase(
            saleRepository: $saleRepository,
            sellerRepository: $sellerRepository
        );
        $sale = $useCase->execute('fulano@example.com', 500.0);

        $this->assertInstanceOf(Sale::class, $sale);
        $this->assertEquals(500.0, $sale->getAmount());
        $this->assertEquals(42.5, $sale->getCommission());
    }
}
