<?php

declare(strict_types=1);


namespace Yanis\Apify\Dataset\Item;

interface Item
{
    public static function fromArray(array $state): static;
}