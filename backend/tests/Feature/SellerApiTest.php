<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests integration sellers.
 */
class SellerApiTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSellerNotInvalid(): void
    {
        $response = $this->postJson('/api/sellers', [
            'name' => '',
            'email' => 'email-invalid'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email']);
    }
}
