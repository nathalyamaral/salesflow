<?php

namespace Tests\Unit\Application\UseCase;

/**
 * Unit tests for RegisterSaleUseCase.
 */
class RegisterSaleUseCaseTest extends TestCase
{
    public function registerSale(): void
    {
        $seller = new Seller(1, 'Fulano Tal', 'fulano@example.com');

        $sellerRepository = $this->createMock(SellerRepositoryInterface::class);
        $sellerRepository->method('findByEmail')->willReturn($seller);

        $saleRepository = $this->createMock(SaleRepositoryInterface::class);
        $saleRepository->expects($this->once())
            ->method('save')
            ->willReturn(new Sale(1, $seller, 500.0, 42.5, new \DateTime('2024-02-07')));

        $useCase = new RegisterSaleUseCase($saleRepository, $sellerRepository);
        $sale = $useCase->execute('fulano@example.com', 500.0);

        $this->assertInstanceOf(Sale::class, $sale);
        $this->assertEquals(500.0, $sale->getAmount());
        $this->assertEquals(42.5, $sale->getCommission());
    }
}
