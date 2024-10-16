<?php

namespace Tests\Unit;

use App\Events\OrderCreated;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    public function testCreateOrderSuccessfully()
    {
        $orderData = [
            'id' => 'A0000001',
            'price' => 100,
            'currency' => 'USD',
            'address' => [
                'city' => 'Test City',
                'district' => 'Test District',
                'street' => 'Test Street',
            ],
        ];

        Event::fake();

        $orderService = new OrderService();

        $result = $orderService->createOrder($orderData);

        $this->assertEquals('Order created successfully', $result['status']);
        $this->assertEquals('A0000001', $result['order_id']);

        Event::assertDispatched(OrderCreated::class, function ($event) use ($orderData) {
            return $event->order['order_id'] === $orderData['id'] &&
                   $event->order['price'] === $orderData['price'] &&
                   $event->order['currency'] === $orderData['currency'] &&
                   $event->addressData === $orderData['address'];
        });
    }
}
