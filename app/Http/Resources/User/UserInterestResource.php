<?php

namespace App\Http\Resources\User;

use App\Http\Resources\JsonResourceBase;
use Illuminate\Http\Request;


class UserInterestResource extends JsonResourceBase
{
    protected function getPayload(Request $request): array
    {
        $interests = $this->interests->map(function ($userInterest) {
            return [
                'interest_id' => $userInterest->interest_id,
                'name'        => $userInterest->interest->name,
                'proficiency' => $userInterest->proficiency,
                'position'    => $userInterest->position,
            ];
        })->toArray();

        return [
            'name'      => $this->name,
            'email'     => $this->email,
            'interests' => $interests,
        ];
    }
}
