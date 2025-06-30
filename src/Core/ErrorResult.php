<?php

declare(strict_types=1);

namespace DocAxess\Apify\Core;

use Stringable;

readonly class ErrorResult implements Stringable
{
    public function __construct(
        public int $httpCode,
        public string $message,
        public string $type
    ) {}

    /**
     * @param  array{error: array{message: string, type: string}}  $state
     */
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
        return sprintf('Error: %s (%s) with HTTP code: %d', $this->message, $this->type, $this->httpCode);
    }
}
