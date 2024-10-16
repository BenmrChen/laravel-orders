<?php

namespace Tests\Unit;

use App\Events\OrderCreated;
use App\Listeners\OrderCreatedListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCreatedListenerTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderCreatedListener()
    {
        $addressData = [
            'city' => 'Test City',
            'district' => 'Test District',
            'street' => 'Test Street',
        ];

        $orderData = [
            'order_id' => 'A0000001',
            'price' => '100',
            'currency' => 'USD',
        ];

        $event = new OrderCreated($orderData, $addressData);

        $listener = new OrderCreatedListener();

        $listener->handle($event);

        $this->assertDatabaseHas('addresses', $addressData);

        $this->assertDatabaseHas('orders_usd', [
            'order_id' => 'A0000001',
            'price' => '100',
        ]);
    }
}
