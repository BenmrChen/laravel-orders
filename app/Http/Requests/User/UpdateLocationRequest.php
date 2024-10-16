<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId'     => 'required|integer|exists:users,id',
            'locationId' => 'required|integer|exists:locations,id',
            'action'     => 'required|string|in:SET_ACTIVE,REMOVE,ADD'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'userId' => $this->route('userId'),
        ]);
    }
}
