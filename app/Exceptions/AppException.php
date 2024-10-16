<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class AppException extends Exception
{
    protected array $meta = [];

    public function __construct(int $httpCode, string $message, ?array $meta = [])
    {
        $this->meta = $meta ?? [];

        parent::__construct($message, $httpCode);
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function getMeta(?string $key = null): array
    {
        if ($key) {
            return Arr::get($this->meta, $key);
        }

        return $this->meta;
    }

    public function render(): JsonResponse
    {
        $statusCode = $this->getCode();
        $message    = $this->getMessage();
        $meta       = $this->getMeta();

        if ($meta) {
            $errors[] = compact('message', 'meta');
        } else {
            $errors[] = compact('message');
        }

        return response()->json(compact('errors'), $statusCode);
    }}
