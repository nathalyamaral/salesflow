<?php

namespace Tests\Unit\Application\UseCase;

use Application\UseCases\RegisterSellerUseCase;
use Domain\Entities\Seller;
use Domain\Repositories\SellerRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for RegisterSellerUseCase.
 */
class RegisterSellerUseCaseTest extends TestCase
{
    public function testRegisterSeller(): void
    {
        $repository = $this->createMock(SellerRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('save')
            ->willReturn(new Seller(1, 'Fulano Tal', 'fulano@example.com'));

        $useCase = new RegisterSellerUseCase($repository);
        $seller = $useCase->execute('Fulano Tal', 'fulano@example.com');

        $this->assertInstanceOf(Seller::class, $seller);
        $this->assertEquals('Fulano Tal', $seller->getName());
        $this->assertEquals('fulano@example.com', $seller->getEmail());
    }
}
