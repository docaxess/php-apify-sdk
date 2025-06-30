<?php

declare(strict_types=1);

namespace DocAxess\Apify\Dataset\Request;

use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\Dataset\Item\Item;
use DocAxess\Apify\Dataset\Option\DatasetOption;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;

class DatasetRequest extends Request
{
    use CreatesDtoFromResponse;

    protected Method $method = Method::GET;

    public function __construct(public readonly DatasetOption $option) {}

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

    protected function defaultQuery(): array
    {
        return $this->option->toParams();
    }

    /**
     * @return array<int, Item|array<string, mixed>>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        if (! is_array($data)) {
            return [];
        }

        /** @var array<int, array<string, mixed>> */
        return array_map(
            function (mixed $item) {
                if (is_null($this->option->dtoType)) {
                    return is_array($item) ? $item : [];
                }

                if (! is_array($item)) {
                    throw new JsonException('Expected array items from response');
                }

                /** @var array<string, mixed> $item */
                return $this->option->dtoType::fromArray($item);
            },
            $data
        );
    }
}
