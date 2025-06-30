<?php

declare(strict_types=1);

namespace DocAxess\Apify\Dataset\Option;

readonly class Pagination implements \JsonSerializable
{
    public function __construct(
        public ?int $limit,
        public ?int $offset,
    ) {}

    public static function disabled(): self
    {
        return new self(null, null);
    }

    public static function enabled(int $limit = 100, int $offset = 0): self
    {
        return new self($limit, $offset);
    }

    public function isDisabled(): bool
    {
        return $this->limit === null && $this->offset === null;
    }

    /**
     * @return array<string, int|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];
    }
}
