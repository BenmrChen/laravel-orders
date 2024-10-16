<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId' => 'required|integer|exists:users,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'userId' => $this->route('userId'),
        ]);
    }
}
