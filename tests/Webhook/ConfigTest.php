<?php

declare(strict_types=1);

use DocAxess\Apify\Webhook\Config\WebhookConfig;
use DocAxess\Apify\Webhook\Event\EventType;

it('should create config', function () {
    $config = new WebhookConfig([EventType::RUN_SUCCEEDED, EventType::RUN_CREATED], 'https://example.com');
    expect($config->eventTypes)->toBe([EventType::RUN_SUCCEEDED, EventType::RUN_CREATED])
        ->and($config->url)->toBe('https://example.com')
        ->and($config->template)->toBeNull();
});

it('should add event type', function () {
    $config = new WebhookConfig([EventType::RUN_SUCCEEDED], 'https://example.com');
    $config = $config->addEventType(EventType::RUN_CREATED);
    expect($config->eventTypes)->toBe([EventType::RUN_SUCCEEDED, EventType::RUN_CREATED]);
});

it('should serialize to json', function (WebhookConfig $config, string $expected) {
    expect(json_encode($config))->toBe($expected);
})->with([
    [
        new WebhookConfig([EventType::RUN_SUCCEEDED], 'https://example.com', 'template'),
        '{"eventTypes":["ACTOR.RUN.SUCCEEDED"],"requestUrl":"https:\/\/example.com","payloadTemplate":"template"}',
    ],
    [
        new WebhookConfig([EventType::RUN_SUCCEEDED], 'https://example.com'),
        '{"eventTypes":["ACTOR.RUN.SUCCEEDED"],"requestUrl":"https:\/\/example.com"}',
    ],
]);

it('should throw exception for invalid event type', function () {
    new WebhookConfig(['invalid'], 'https://example.com');
})->throws(AssertionError::class);
