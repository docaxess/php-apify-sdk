<?php

declare(strict_types=1);

namespace DocAxess\Apify\KeyValueStore\Request;

use DocAxess\Apify\Core\Type\Identifier;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class KeyValueStoreRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public readonly Identifier $storeId,
        public readonly string $key,
        public readonly bool $binary = false
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('key-value-stores/%s/records/%s', $this->storeId, $this->key);
    }

    protected function defaultHeaders(): array
    {
        if ($this->binary) {
            // Override content type for binary data
            return [];
        }

        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
