<?php

declare(strict_types=1);

namespace DocAxess\Apify\Dataset\Resource;

use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\Dataset\Item\Item;
use DocAxess\Apify\Dataset\Request\DatasetRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class DatasetResource extends BaseResource
{
    /**
     * @param  class-string<Item>|null  $dtoType
     * @return array<int, Item|array<string, mixed>>
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getJson(Identifier $identifier, ?string $dtoType = null): array
    {
        /** @var array<int, Item|array<string, mixed>> $result */
        $result = $this->connector->send(DatasetRequest::getJson($identifier, $dtoType))->dto();

        return $result;
    }
}
