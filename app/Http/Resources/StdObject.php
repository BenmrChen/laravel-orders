<?php

namespace App\Http\Resources;

class StdObject
{
    public function __construct(array $arguments = [])
    {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    }

    public function __get(string $name): mixed
    {
        return $this->{$name} ?? null;
    }
}
