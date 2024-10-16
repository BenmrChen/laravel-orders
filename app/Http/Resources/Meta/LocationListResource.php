<?php

namespace App\Http\Resources\Meta;

use App\Http\Resources\JsonResourceBase;
use Illuminate\Http\Request;

class LocationListResource extends JsonResourceBase
{
    protected function getPayload(Request $request): array
    {
        return $this->resource->map(function ($location) {
            return [
                'id'   => $location->id,
                'name' => $location->name,
            ];
        })->toArray();
    }
}
