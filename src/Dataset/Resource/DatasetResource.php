<?php

declare(strict_types=1);

namespace Yanis\Apify\Dataset\Resource;

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Yanis\Apify\Core\Type\Identifier;
use Yanis\Apify\Dataset\Item\Item;
use Yanis\Apify\Dataset\Request\DatasetRequest;

class DatasetResource extends BaseResource
{
    /**
     * @param  class-string<Item>|null  $dtoType
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getJson(Identifier $identifier, ?string $dtoType = null): array
    {
        return $this->connector->send(DatasetRequest::getJson($identifier, $dtoType))->dto();
    }
}
