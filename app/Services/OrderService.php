<?php

namespace App\Services;

use App\Events\OrderCreated;

class OrderService
{
    public function createOrder(array $data)
    {
        $currency = $data['currency'];
        $orderId = $data['id'];
        $price = $data['price'];

        event(new OrderCreated([
            'order_id' => $orderId,
            'price' => $price,
            'currency' => $currency,
        ], $data['address']));

        return [
            'status' => 'Order created successfully',
            'order_id' => $orderId,
        ];
    }
}
