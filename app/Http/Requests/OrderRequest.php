<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'id'               => 'required|string',
            'name'             => 'required|string',
            'address.city'     => 'required|string',
            'address.district' => 'required|string',
            'address.street'   => 'required|string',
            'price'            => 'required|numeric',
            'currency'         => 'required|in:TWD,USD,JPY,RMB,MYR',
        ];

        $tableMap = [
            'TWD' => 'orders_twd',
            'USD' => 'orders_usd',
            'JPY' => 'orders_jpy',
            'RMB' => 'orders_rmb',
            'MYR' => 'orders_myr',
        ];

        if (array_key_exists($this->currency, $tableMap)) {
            $rules['id'] = [
                'required',
                'string',
                Rule::unique($tableMap[$this->currency], 'order_id')
            ];
        }

        return $rules;
    }
}
