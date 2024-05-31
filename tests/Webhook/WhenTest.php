<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use DocAxess\Apify\Webhook\Data\Moment\When;

$now = CarbonImmutable::now();

it('should create when', function () use ($now) {
    $startedAt = $now;
    $finishedAt = $now;
    $when = When::make($startedAt, $finishedAt);
    expect($when->startedAt)->toBe($startedAt)
        ->and($when->finishedAt)->toBe($finishedAt);
});

it('should create when from array', function (array $payload) use ($now) {
    $when = When::fromArray($payload);
    expect((string) $when->startedAt)->toBe((string) $now)
        ->and((string) $when->finishedAt)->toBe((string) $now);
})->with([
    [['startedAt' => $now->toIso8601String(), 'finishedAt' => $now->toIso8601String()]],
    ['resource' => ['startedAt' => $now->toIso8601String(), 'finishedAt' => $now->toIso8601String()]],
]);

it('should create when from array without finishedAt', function (array $payload) use ($now) {
    $startedAt = $now;
    $when = When::fromArray($payload);
    expect((string) $when->startedAt)->toBe((string) $startedAt)
        ->and($when->finishedAt)->toBeNull();
})->with([
    [['startedAt' => $now->toIso8601String()]],
    ['resource' => ['startedAt' => $now->toIso8601String()]],
]);

it('should check if when is finished', function () use ($now) {
    $startedAt = $now;
    $finishedAt = $now;
    $when = When::make($startedAt, $finishedAt);
    expect($when->isFinished())->toBeTrue();
});

it('should check if when is running', function () use ($now) {
    $startedAt = $now;
    $when = When::make($startedAt, null);
    expect($when->isRunning())->toBeTrue();
});

it('should calculate execution time in seconds', function () use ($now) {
    $startedAt = $now;
    $finishedAt = $now->addSeconds(10);
    $when = When::make($startedAt, $finishedAt);
    expect($when->executionTimeInSeconds())->toBe(10);
});
