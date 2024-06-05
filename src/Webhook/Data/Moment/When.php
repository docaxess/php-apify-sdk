<?php

declare(strict_types=1);

namespace DocAxess\Apify\Webhook\Data\Moment;

use Carbon\CarbonImmutable;

class When
{
    public function __construct(
        public CarbonImmutable $startedAt,
        public ?CarbonImmutable $finishedAt,
    ) {

    }

    public static function make(CarbonImmutable $createdAt, ?CarbonImmutable $finishedAt): self
    {
        return new self($createdAt, $finishedAt);
    }

    public static function fromArray(array $state): self
    {
        $state = $state['resource'] ?? $state;

        return new self(
            CarbonImmutable::parse($state['startedAt']),
            isset($state['finishedAt']) ? CarbonImmutable::parse($state['finishedAt']) : null,
        );
    }

    public function isFinished(): bool
    {
        return $this->finishedAt !== null;
    }

    public function isRunning(): bool
    {
        return $this->finishedAt === null;
    }

    public function executionTimeInSeconds(): float
    {
        return $this->startedAt->diffInSeconds($this->finishedAt ?? CarbonImmutable::now());
    }
}
