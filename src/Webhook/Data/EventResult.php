<?php

declare(strict_types=1);

namespace Yanis\Apify\Webhook\Data;

use Carbon\CarbonImmutable;
use Yanis\Apify\Core\Type\Identifier;
use Yanis\Apify\Core\Type\Status;
use Yanis\Apify\Webhook\Data\Moment\When;
use Yanis\Apify\Webhook\Event\EventType;

readonly class EventResult
{
    public function __construct(
        public Identifier $id,
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
            emittedAt: CarbonImmutable::parse($state['createdAt']),
            eventType: EventType::fromString($state['eventType']),
            status: Status::fromString($resource['status']),
            when: When::fromArray($resource),
        );
    }
}
