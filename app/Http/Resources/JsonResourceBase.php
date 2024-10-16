<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/** @phpstan-consistent-constructor */
abstract class JsonResourceBase extends JsonResource
{
    public bool $preserveKeys              = false;
    public bool $convertEmptyArrayToObject = false;

    protected array $dateTimeFields = [
        'createdAt',
        'updatedAt',
    ];

    public function __construct($resource)
    {
        $target = is_array($resource) ? new StdObject($resource) : $resource;
        parent::__construct($target);
    }

    public static function collection(mixed $resource): JsonResourceCollection
    {
        return tap(new JsonResourceCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

    public function toArray($request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return $this->convert($this->getPayload($request));
    }

    public function getPagination(LengthAwarePaginator $resource): array
    {
        return [
            'meta' => [
                'totalRows'   => $resource->total(),
                'totalPages'  => $resource->lastPage(),
                'pageSize'    => $resource->perPage(),
                'currentPage' => $resource->currentPage(),
            ],
        ];
    }

    protected function convert(array $payload): array
    {
        foreach ($this->dateTimeFields as $field) {
            if (Arr::has($payload, $field)) {
                $value = Arr::get($payload, $field);

                if ($value instanceof Carbon) {
                    Arr::set($payload, $field, $value->toIso8601String());
                }
            }
        }

        if ($this->convertEmptyArrayToObject === true) {
            $this->convertEmptyArrayToObject($payload);
        }

        return $payload;
    }

    protected function convertEmptyArrayToObject(array &$payload): bool
    {
        foreach ($payload as &$data) {
            if (is_array($data)) {
                if (empty($data)) {
                    $data = (object) [];
                } else {
                    $this->convertEmptyArrayToObject($data);
                }
            }
        }

        return true;
    }

    abstract protected function getPayload(Request $request): array;
}
