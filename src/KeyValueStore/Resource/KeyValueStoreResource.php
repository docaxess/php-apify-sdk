<?php

declare(strict_types=1);

namespace DocAxess\Apify\KeyValueStore\Resource;

use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\KeyValueStore\Request\KeyValueStoreRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class KeyValueStoreResource extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getRecord(Identifier $storeId, string $key): mixed
    {
        return $this->connector->send(
            new KeyValueStoreRequest($storeId, $key)
        )->body();
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getBinaryRecord(Identifier $storeId, string $key): string
    {
        return $this->connector->send(
            new KeyValueStoreRequest($storeId, $key, true)
        )->body();
    }

    /**
     * Download multiple files from key-value store
     *
     * @param  array<string>  $keys
     * @return array<string, string>
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getBinaryRecords(Identifier $storeId, array $keys): array
    {
        return array_map(function (string $key) use ($storeId) {
            return $this->getBinaryRecord($storeId, $key);
        }, $keys);
    }
}
