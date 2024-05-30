<?php

declare(strict_types=1);

use Yanis\Apify\Webhook\Data\EventResult;
use Yanis\Apify\Webhook\Event\EventType;

it('should create an event result from Webhook call', function (EventType $eventType) {
    $request = $this->fixture(sprintf('webhook/%s', $eventType->value));
    $result = EventResult::fromArray($request);
    expect($result)->toBeInstanceOf(EventResult::class);
})
    ->with([
        EventType::RUN_CREATED,
        EventType::RUN_SUCCEEDED,
    ]);
