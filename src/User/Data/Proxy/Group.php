<?php

declare(strict_types=1);

namespace DocAxess\Apify\User\Data\Proxy;

readonly class Group
{
    public function __construct(
        public string $name,
        public string $description,
        public int $availableCount
    ) {
        assert($availableCount >= 0, 'Available count must be greater than or equal to 0');
    }

    /**
     * @param  array<string, mixed>  $group
     */
    public static function make(mixed $group): self
    {
        return new self(
            name: $group['name'],
            description: $group['description'],
            availableCount: $group['availableCount']
        );
    }
}
