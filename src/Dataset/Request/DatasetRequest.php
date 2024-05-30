<?php

declare(strict_types=1);

namespace Yanis\Apify\Dataset\Request;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use Yanis\Apify\Core\Type\Identifier;
use Yanis\Apify\Dataset\Item\Item;
use Yanis\Apify\Dataset\Option\DatasetOption;

class DatasetRequest extends Request
{
    use CreatesDtoFromResponse;

    protected Method $method = Method::GET;

    public function __construct(public readonly DatasetOption $option)
    {

    }

    /**
     * @param class-string<Item>|null $dtoType
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
            fn(array $item) => is_null($this->option->dtoType) ? $item : $this->option->dtoType::fromArray($item),
            $response->json()
        );
    }
}
