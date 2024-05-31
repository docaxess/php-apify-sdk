<?php

declare(strict_types=1);

namespace DocAxess\Apify\Webhook\Data;

use Carbon\CarbonImmutable;
use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\Core\Type\Status;
use DocAxess\Apify\Webhook\Data\Moment\When;
use DocAxess\Apify\Webhook\Event\EventType;

readonly class EventResult
{
    public function __construct(
        public Identifier $id,
        public Identifier $keyValueStoreId,
        public Identifier $datasetId,
        public Identifier $requestQueueId,
        public CarbonImmutable $emittedAt,
        public EventType $eventType,
        public Status $status,
        public When $when,
    ) {
    }

    public static function fromArray(array $state): self
    {
        $resource = $state['resource'] ?? throw new \InvalidArgumentException('Resource is required');

        return new self(
            id: Identifier::make($resource['id']),
            keyValueStoreId: Identifier::make($resource['defaultKeyValueStoreId']),
            datasetId: Identifier::make($resource['defaultDatasetId']),
            requestQueueId: Identifier::make($resource['defaultRequestQueueId']),
            emittedAt: CarbonImmutable::parse($state['createdAt']),
            eventType: EventType::fromString($state['eventType']),
            status: Status::fromString($resource['status']),
            when: When::fromArray($resource),
        );
    }
}
