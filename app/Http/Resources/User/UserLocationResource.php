<?php

namespace App\Http\Resources\User;

use App\Http\Resources\JsonResourceBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserLocationResource extends JsonResourceBase
{
    protected function getPayload(Request $request): array
    {
        $locations = $this->locations->map(function ($location) {
            return [
                'name'     => $location->name,
                'isActive' => $location->pivot->is_active ?? false,
            ];
        })->toArray();

        return [
            'name'      => $this->name,
            'email'     => $this->email,
            'locations' => $locations,
        ];
    }
}
