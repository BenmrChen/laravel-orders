<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInterestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId'                  => 'required|integer|exists:users,id',
            'interests'               => 'required|array',
            'interests.*.interest_id' => 'required|integer|exists:interests,id',
            'interests.*.proficiency' => 'required|string',
            'interests.*.position'    => 'nullable|string' // todo: 驗證 proficiency, position
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'userId' => $this->route('userId'),
        ]);
    }
}
