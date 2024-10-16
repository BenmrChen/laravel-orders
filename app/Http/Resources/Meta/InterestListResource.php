<?php

namespace App\Http\Resources\Meta;

use App\Http\Resources\JsonResourceBase;
use Illuminate\Http\Request;

class InterestListResource extends JsonResourceBase
{
    protected function getPayload(Request $request): array
    {
        return $this->resource->map(function ($interest) {
            return [
                'id'          => $interest->id,
                'name'        => $interest->name,
                'proficiency' => $interest->proficiency,
                'position'    => $interest->position,
            ];
        })->toArray();
    }
}
