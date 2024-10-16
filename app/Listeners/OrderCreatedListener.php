<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\Address;

class OrderCreatedListener
{
    public function handle(OrderCreated $event)
    {
        $address = Address::create($event->addressData);

        $order = new Order([
            'order_id' => $event->order['order_id'],
            'address_id' => $address->id,
            'price' => $event->order['price'],
        ]);

        $table = $this->getTableName($event->order['currency']);
        $order->setTable($table);
        $order->save();
    }

    private function getTableName($currency)
    {
        $tableMap = [
            'TWD' => 'orders_twd',
            'USD' => 'orders_usd',
            'JPY' => 'orders_jpy',
            'RMB' => 'orders_rmb',
            'MYR' => 'orders_myr',
        ];

        return $tableMap[$currency] ?? 'orders_usd';
    }
}
