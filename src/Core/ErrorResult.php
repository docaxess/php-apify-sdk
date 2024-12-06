<?php

declare(strict_types=1);

namespace DocAxess\Apify\Core;

class ErrorResult
{
    public function __construct(
        public int $httpCode,
        public string $message,
        public string $type
    ) {}

    public static function make(int $httpCode, array $state): self
    {
        return new self(
            httpCode: $httpCode,
            message: $state['error']['message'],
            type: $state['error']['type']
        );
    }

    public function isSuccess(): bool
    {
        return false;
    }

    public function __toString(): string
    {
        return "Error: {$this->message} ({$this->type}) with HTTP code: {$this->httpCode}";
    }
}
