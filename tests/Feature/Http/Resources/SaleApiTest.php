<?php

namespace Tests\Feature\Http\Resources;

use App\Models\Seller as SellerModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


/**
 * Feature tests for Sale API.
 */
class SaleApiTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSale(): void
    {
        $seller = SellerModel::create([
            'id' => 1,
            'name' => 'Fulano Tal',
            'email' => 'fulano@example.com'
        ]);

        $response = $this->postJson('/api/sales', [
            'sellerId' => $seller->id,
            'amount' => 500.0
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'seller', 'amount', 'commission', 'date']);
    }
}
