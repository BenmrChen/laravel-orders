<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class OrderCreated
{
    use Dispatchable;

    public $order;
    public $addressData;

    public function __construct(array $order, array $addressData)
    {
        $this->order = $order;
        $this->addressData = $addressData;
    }
}
