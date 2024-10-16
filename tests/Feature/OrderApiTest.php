<?php

namespace Tests\Feature;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Order;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrderSuccess()
    {
        $response = $this->postJson('/api/v1/orders', [
            'id' => 'A0000006',
            'name' => 'API Test Hotel',
            'address' => [
                'city' => 'api-city',
                'district' => 'api-district',
                'street' => 'api-street',
            ],
            'price' => '3000',
            'currency' => 'USD',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Order created successfully',
                'order_id' => 'A0000006',
            ]);

        $this->assertDatabaseHas('orders_usd', ['order_id' => 'A0000006']);
    }

    public function testCreateOrderFailureWithInvalidData()
    {
        $response = $this->postJson('/api/v1/orders', [
            'id' => 'A0000007',
            'name' => 'Invalid Hotel',
            'address' => [
                'city' => 'invalid-city',
                'district' => null,
                'street' => null,
            ],
            'price' => 'not-a-number',
            'currency' => 'INVALID',
        ]);

        $response->assertStatus(422)
            ->assertSee([
                'address.district', 
                'address.street', 
                'price', 
                'currency'
            ]);
    }

    public function testGetOrderSuccess()
    {
        $address = Address::create([
            'city' => 'duplicate-city',
            'district' => 'duplicate-district',
            'street' => 'duplicate-street',
        ]);

        $existingOrder = new Order([
            'order_id' => 'A0000001',
            'address_id' => $address->id,
            'price' => '100',
        ]);
        $existingOrder->setTable('orders_usd');
        $existingOrder->save();

        $response = $this->getJson("/api/v1/orders/{$existingOrder->order_id}?currency=USD");

        $response->assertStatus(200)
            ->assertJson([
                'order_id' => 'A0000001',
                'price' => '100',
            ]);
    }

    public function testGetOrderNotFound()
    {
        $response = $this->getJson('/api/v1/orders/NON_EXISTENT_ID?currency=USD');

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Order not found',
            ]);
    }
}
