<?php

declare(strict_types=1);

namespace DocAxess\Apify\Core\Type;

readonly class Identifier implements \JsonSerializable, \Stringable
{
    public function __construct(public string $id) {}

    public static function make(string $id): self
    {
        return new self($id);
    }

    public function is(Identifier|string $id): bool
    {
        return $this->id === (string) $id;
    }

    public function __toString()
    {
        return $this->id;
    }

    public function jsonSerialize(): string
    {
        return $this->id;
    }
}
