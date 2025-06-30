<?php

declare(strict_types=1);

namespace DocAxess\Apify\Dataset\Option;

use InvalidArgumentException;

/**
 * @source https://docs.apify.com/api/v2#/reference/datasets/item-collection/get-items
 */
enum FormatType: string
{
    case JSON = 'json';
    case JSONL = 'jsonl';
    case CSV = 'csv';
    case XML = 'xml';
    case HTML = 'html';
    case XLSX = 'xlsx';
    case RSS = 'rss';

    public static function fromString(string $type): self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $type) {
                return $case;
            }
        }

        throw new InvalidArgumentException('Unknown format type: '.$type);
    }

    public static function default(): self
    {
        return self::JSON;
    }

    public function is(FormatType $type): bool
    {
        return $this === $type;
    }
}
