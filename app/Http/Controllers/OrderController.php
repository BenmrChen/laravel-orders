<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(OrderRequest $request)
    {
        $response = $this->orderService->createOrder($request->validated());
        return response()->json($response, 200);
    }

    public function show($id): JsonResponse
    {
        $currency = request()->query('currency');
        $tableMap = [
            'TWD' => 'orders_twd',
            'USD' => 'orders_usd',
            'JPY' => 'orders_jpy',
            'RMB' => 'orders_rmb',
            'MYR' => 'orders_myr',
        ];

        if (!array_key_exists($currency, $tableMap)) {
            return response()->json(['error' => 'Invalid currency'], 400);
        }

        $order = DB::table($tableMap[$currency])->where('order_id', $id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
}
