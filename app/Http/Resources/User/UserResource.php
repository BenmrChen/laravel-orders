<?php

namespace App\Http\Resources\User;

use App\Http\Resources\JsonResourceBase;
use Illuminate\Http\Request;


class UserResource extends JsonResourceBase
{
    protected function getPayload(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'accessToken' => $this->token,
        ];
    }
}
