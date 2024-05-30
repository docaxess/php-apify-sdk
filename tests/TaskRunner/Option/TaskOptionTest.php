<?php

declare(strict_types=1);

use Yanis\Apify\Task\Data\Option\TaskOption;
use Yanis\Apify\Webhook\Config\WebhookConfig;
use Yanis\Apify\Webhook\Event\EventType;

it('should create a task option with default values', function () {
    $option = TaskOption::make();

    expect($option->build)->toBe('latest')
        ->and($option->timeout)->toBe(60)
        ->and($option->memory)->toBe(256)
        ->and($option->webhooks)->toBe([]);
});

it('should create a task option with custom values', function () {
    $option = TaskOption::make('1.1.1', 6000, 4086);

    expect($option->build)->toBe('1.1.1')
        ->and($option->timeout)->toBe(6000)
        ->and($option->memory)->toBe(4086)
        ->and($option->webhooks)->toBe([]);
});

it('should add a webhook to the task option', function () {
    $config = WebhookConfig::forEvent(EventType::RUN_CREATED, 'https://example.com');
    $option = TaskOption::make()->addWebhook($config);
    expect($option->webhooks)->toHaveCount(1)
        ->and($option->webhooks)->toContain($config);
});

it('should throw an exception when adding an invalid webhook', fn () => new TaskOption('latest', 60, 256, [new stdClass()])
)->throws(AssertionError::class);

it('should convert the task option to a query string', fn (TaskOption $option, array $params, string $queryString) => expect($option->toParams())->toBe($params)
    ->and((string) $option)->toBe($queryString)
)
    ->with([
        // default values
        [
            TaskOption::make(),
            [],
            '',
        ],
        // custom options
        [
            TaskOption::make('1.1.1', 6000, 4086),
            ['build' => '1.1.1', 'timeout' => 6000, 'memory' => 4086],
            'build=1.1.1&timeout=6000&memory=4086',
        ],
        // custom options with webhooks
        [
            TaskOption::make('1.1.1', 6000, 4086)->addWebhook(WebhookConfig::forEvent(EventType::RUN_CREATED, 'https://example.com')),
            ['build' => '1.1.1', 'timeout' => 6000, 'memory' => 4086, 'webhooks' => base64_encode('[{"eventTypes":["ACTOR.RUN.CREATED"],"requestUrl":"https:\/\/example.com"}]')],
            'build=1.1.1&timeout=6000&memory=4086&webhooks='.base64_encode('[{"eventTypes":["ACTOR.RUN.CREATED"],"requestUrl":"https:\/\/example.com"}]'),
        ],
    ]);
