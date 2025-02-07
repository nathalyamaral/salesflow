<?php

namespace Tests\Feature\Http\Resources;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Domain\Entities\Seller;


/**
 * Feature tests for Sale API.
 */
class SaleApiTest extends TestCase
{
    use RefreshDatabase;

    public function registerSale(): void
    {
        $seller = Seller::create([ 'name' => 'Fulano Tal', 'email' => 'fulano@example.com' ]);

        $response = $this->postJson('/api/sales', [
            'seller_email' => $seller->email,
            'amount' => 500.0
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'seller', 'amount', 'commission', 'date']);
    }
}
