<?php

declare(strict_types=1);

namespace DocAxess\Apify\Dataset\Item;

interface Item
{
    /**
     * @param  array<string, mixed>  $state
     */
    public static function fromArray(array $state): static;
}
