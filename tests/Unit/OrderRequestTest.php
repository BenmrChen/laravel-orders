<?php

namespace Tests\Unit;

use App\Http\Requests\OrderRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testValidOrderRequest()
    {
        $orderData = [
            'id' => 'A0000001',
            'name' => 'Test Hotel',
            'address' => [
                'city' => 'test-city',
                'district' => 'test-district',
                'street' => 'test-street',
            ],
            'price' => '100',
            'currency' => 'TWD',
        ];

        $request = new \Illuminate\Http\Request($orderData);
        $request->setMethod('POST');

        $this->app['validator']->validate($request->all(), (new OrderRequest())->rules());
        $this->assertTrue(true); // If no exception is thrown, the test passes
    }

    public function testMissingId()
    {
        $orderData = [
            'name' => 'Test Hotel',
            'address' => [
                'city' => 'test-city',
                'district' => 'test-district',
                'street' => 'test-street',
            ],
            'price' => '100',
            'currency' => 'TWD',
        ];

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $request = new \Illuminate\Http\Request($orderData);
        $request->setMethod('POST');
        $this->app['validator']->validate($request->all(), (new OrderRequest())->rules());
    }

    public function testInvalidPrice()
    {
        $orderData = [
            'id' => 'A0000001',
            'name' => 'Test Hotel',
            'address' => [
                'city' => 'test-city',
                'district' => 'test-district',
                'street' => 'test-street',
            ],
            'price' => 'not_a_number',
            'currency' => 'TWD',
        ];

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $request = new \Illuminate\Http\Request($orderData);
        $request->setMethod('POST');
        $this->app['validator']->validate($request->all(), (new OrderRequest())->rules());
    }

    public function testInvalidCurrency()
    {
        $orderData = [
            'id' => 'A0000001',
            'name' => 'Test Hotel',
            'address' => [
                'city' => 'test-city',
                'district' => 'test-district',
                'street' => 'test-street',
            ],
            'price' => '100',
            'currency' => 'INVALID',
        ];

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $request = new \Illuminate\Http\Request($orderData);
        $request->setMethod('POST');
        $this->app['validator']->validate($request->all(), (new OrderRequest())->rules());
    }
}
