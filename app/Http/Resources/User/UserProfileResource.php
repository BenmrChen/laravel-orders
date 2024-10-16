<?php

namespace App\Http\Resources\User;

use App\Http\Resources\JsonResourceBase;
use Illuminate\Http\Request;


class UserProfileResource extends JsonResourceBase
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

        $locations = $this->locations->map(function ($location) {
            return [
                'name'     => $location->name,
                'isActive' => $location->pivot->is_active ?? false,
            ];
        })->toArray();

        return [
            'name'      => $this->name,
            'username'  => $this->username,
            'bio'       => $this->bio,
            'gender'    => $this->gender,
            'ageGroup'  => $this->age_group,
            'email'     => $this->email,
            'interests' => $interests,
            'locations' => $locations,
        ];
    }
}
