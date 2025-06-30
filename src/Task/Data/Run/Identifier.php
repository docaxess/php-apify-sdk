<?php

declare(strict_types=1);

namespace DocAxess\Apify\Task\Data\Run;

use DocAxess\Apify\Core\Type\Identifier as AtomicIdentifier;

readonly class Identifier
{
    public function __construct(
        public AtomicIdentifier $id,
        public AtomicIdentifier $actId,
        public AtomicIdentifier $userId,
        public ?AtomicIdentifier $actorTaskId,
        public AtomicIdentifier $buildId,
        public AtomicIdentifier $defaultKeyValueStoreId,
        public AtomicIdentifier $defaultDatasetId,
        public AtomicIdentifier $defaultRequestQueueId,
    ) {}

    /**
     * @param  array<string, string>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: AtomicIdentifier::make($data['id']),
            actId: AtomicIdentifier::make($data['actId']),
            userId: AtomicIdentifier::make($data['userId']),
            actorTaskId: isset($data['actorTaskId']) && $data['actorTaskId'] !== ''
                ? AtomicIdentifier::make($data['actorTaskId'])
                : null,
            buildId: AtomicIdentifier::make($data['buildId']),
            defaultKeyValueStoreId: AtomicIdentifier::make($data['defaultKeyValueStoreId']),
            defaultDatasetId: AtomicIdentifier::make($data['defaultDatasetId']),
            defaultRequestQueueId: AtomicIdentifier::make($data['defaultRequestQueueId']),
        );
    }
}
