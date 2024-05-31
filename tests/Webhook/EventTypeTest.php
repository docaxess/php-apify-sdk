<?php

declare(strict_types=1);

use DocAxess\Apify\Webhook\Event\EventType;

dataset('eventType', [
    [EventType::BUILD_CREATED, 'ACTOR.BUILD.CREATED'],
    [EventType::BUILD_SUCCEEDED, 'ACTOR.BUILD.SUCCEEDED'],
    [EventType::BUILD_FAILED, 'ACTOR.BUILD.FAILED'],
    [EventType::BUILD_ABORTED, 'ACTOR.BUILD.ABORTED'],
    [EventType::BUILD_TIMED_OUT, 'ACTOR.BUILD.TIMED_OUT'],
    [EventType::RUN_CREATED, 'ACTOR.RUN.CREATED'],
    [EventType::RUN_SUCCEEDED, 'ACTOR.RUN.SUCCEEDED'],
    [EventType::RUN_FAILED, 'ACTOR.RUN.FAILED'],
    [EventType::RUN_ABORTED, 'ACTOR.RUN.ABORTED'],
    [EventType::RUN_TIMED_OUT, 'ACTOR.RUN.TIMED_OUT'],
    [EventType::RUN_RESURRECTED, 'ACTOR.RUN.RESURRECTED'],
]);

it('create event type from string',
    fn (EventType $expected, string $value) => expect(EventType::fromString($value))->toBe($expected))
    ->with('eventType');

it('throw exception when creating event type from invalid string',
    fn () => EventType::fromString('INVALID_EVENT_TYPE'))
    ->throws(InvalidArgumentException::class);
