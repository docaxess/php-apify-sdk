<?php

declare(strict_types=1);

namespace DocAxess\Apify\Webhook\Data;

use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\Core\Type\Status;
use DocAxess\Apify\Webhook\Data\Moment\When;
use DocAxess\Apify\Webhook\Event\EventType;
use InvalidArgumentException;

readonly class EventResult
{
    public function __construct(
        public Identifier $id,
        public Identifier $keyValueStoreId,
        public Identifier $datasetId,
        public string $statusMessage,
        public EventType $eventType,
        public Status $status,
        public int $exitCode,
        public When $when,
    ) {}

    /**
     * Creates an instance of the class from a provided state array.
     *
     * @param array{
     *     resource: array{
     *         id: string,
     *         defaultKeyValueStoreId: string,
     *         defaultDatasetId: string,
     *         status: string,
     *         startedAt?: string,
     *         finishedAt?: string,
     *         exitCode: int,
     *         statusMessage: string,
     *     },
     *     createdAt: string,
     *     eventType: string
     * } $state The input state array containing the data required to construct the instance.
     * @return self A new instance of the class populated with data from the input state array.
     *
     * @throws InvalidArgumentException If the required 'resource' key is missing in the state array.
     */
    public static function fromArray(array $state): self
    {
        $resource = $state['resource'] ?? throw new InvalidArgumentException('Resource is required');

        return new self(
            id: Identifier::make($resource['id']),
            keyValueStoreId: Identifier::make($resource['defaultKeyValueStoreId']),
            datasetId: Identifier::make($resource['defaultDatasetId']),
            statusMessage: $resource['statusMessage'] ?? '',
            eventType: EventType::fromString($state['eventType']),
            status: Status::fromString($resource['status']),
            exitCode: $resource['exitCode'] ?? 0,
            when: When::fromArray($resource),
        );
    }
}
