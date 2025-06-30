<?php

declare(strict_types=1);

namespace DocAxess\Apify\Dataset\Option;

use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\Dataset\Item\Item;
use InvalidArgumentException;

readonly class DatasetOption implements \JsonSerializable
{
    /**
     * @param  class-string<Item>|null  $dtoType
     */
    public function __construct(
        public Identifier $identifier,
        public FormatType $formatType,
        public Pagination $pagination,
        public ?string $dtoType = null,
    ) {
        if ($dtoType !== null && ! is_subclass_of($dtoType, Item::class)) {
            throw new InvalidArgumentException('DTO type must implement '.Item::class);
        }
    }

    /**
     * @param  class-string<Item>|null  $dtoType
     */
    public static function fromId(Identifier $identifier, ?string $dtoType = null): self
    {
        return new self($identifier, FormatType::default(), Pagination::disabled(), $dtoType);
    }

    /**
     * @param  class-string<Item>|null  $dtoType
     */
    public static function make(
        Identifier $identifier,
        FormatType $formatType,
        Pagination $pagination,
        ?string $dtoType = null
    ): self {
        return new self($identifier, $formatType, $pagination, $dtoType);
    }

    /**
     * Converts the current state into an array of parameters based on format and pagination settings.
     *
     * @return array<string, mixed> Associative array of parameters including conditional format and pagination data.
     */
    public function toParams(): array
    {
        return [
            'clean' => true,
            ...($this->formatType->is(FormatType::default()) ? [] : ['format' => $this->formatType->value]),
            ...($this->pagination->isDisabled() ? [] : $this->pagination->jsonSerialize()),
        ];
    }

    /**
     * Converts the object into a JSON serializable format.
     *
     * @return array<string, mixed> An associative array representing the serialized object.
     */
    public function jsonSerialize(): array
    {
        return [
            'identifier' => $this->identifier,
            'formatType' => $this->formatType->value,
            'pagination' => $this->pagination,
        ];
    }
}
