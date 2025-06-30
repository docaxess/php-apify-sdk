<?php

declare(strict_types=1);

namespace DocAxess\Apify\Webhook\Data\Moment;

use Carbon\CarbonImmutable;

readonly class When
{
    public function __construct(
        public CarbonImmutable $startedAt,
        public ?CarbonImmutable $finishedAt,
    ) {}

    /**
     * Constructs a new instance of the class using the provided creation and optional finish timestamps.
     *
     * @param  CarbonImmutable  $createdAt  The timestamp indicating the creation time.
     * @param  CarbonImmutable|null  $finishedAt  The optional timestamp indicating the finish time.
     * @return self Returns a new instance of the class.
     */
    public static function make(CarbonImmutable $createdAt, ?CarbonImmutable $finishedAt): self
    {
        return new self($createdAt, $finishedAt);
    }

    /**
     * @param array{
     *     resource?: array{startedAt: string, finishedAt?: string},
     *     startedAt?: string,
     *     finishedAt?: string
     * } $state
     */
    public static function fromArray(array $state): self
    {
        /** @var array<string, string> $state */
        $state = $state['resource'] ?? $state;

        return new self(
            CarbonImmutable::parse($state['startedAt']),
            isset($state['finishedAt']) ? CarbonImmutable::parse($state['finishedAt']) : null,
        );
    }

    public function isFinished(): bool
    {
        return $this->finishedAt instanceof CarbonImmutable;
    }

    public function isRunning(): bool
    {
        return ! $this->finishedAt instanceof CarbonImmutable;
    }

    public function executionTimeInSeconds(): float
    {
        return $this->startedAt->diffInSeconds($this->finishedAt ?? CarbonImmutable::now());
    }
}
