<?php

declare(strict_types=1);

namespace DocAxess\Apify\Dataset\Request;

use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\Dataset\Item\Item;
use DocAxess\Apify\Dataset\Option\DatasetOption;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;

class DatasetRequest extends Request
{
    use CreatesDtoFromResponse;

    protected Method $method = Method::GET;

    public function __construct(public readonly DatasetOption $option)
    {

    }

    /**
     * @param  class-string<Item>|null  $dtoType
     */
    public static function getJson(Identifier $identifier, ?string $dtoType = null): self
    {
        return new self(DatasetOption::fromId($identifier, $dtoType));
    }

    public function resolveEndpoint(): string
    {
        return sprintf('datasets/%s/items', $this->option->identifier);
    }

    public function defaultQuery(): array
    {
        return $this->option->toParams();
    }

    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $item) => is_null($this->option->dtoType) ? $item : $this->option->dtoType::fromArray($item),
            $response->json()
        );
    }
}
