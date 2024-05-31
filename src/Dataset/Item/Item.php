<?php

declare(strict_types=1);

namespace DocAxess\Apify\Dataset\Item;

interface Item
{
    public static function fromArray(array $state): static;
}
