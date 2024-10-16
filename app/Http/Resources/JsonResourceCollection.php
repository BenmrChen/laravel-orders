<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class JsonResourceCollection extends ResourceCollection
{
    public bool $preserveKeys = false;

    public function __construct(mixed $resource, string $collects)
    {
        $this->collects = $collects;
        parent::__construct($resource);
    }

    public function paginationInformation(Request $request, array $paginated): array
    {
        return Arr::has($paginated, 'next_cursor')
            ? [
                'meta' => [
                    'nextCursor' => $paginated['next_cursor'] ?? null,
                    'perPage'    => $paginated['per_page'] ?? null,
                ],
            ]
            : [
                'meta' => [
                    'totalRows'   => $paginated['total'] ?? null,
                    'totalPages'  => $paginated['last_page'] ?? null,
                    'currentPage' => $paginated['current_page'] ?? null,
                    'perPage'     => $paginated['per_page'] ?? null,
                ],
            ];
    }
}
