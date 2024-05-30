<?php

declare(strict_types=1);

use Yanis\Apify\Core\Type\Status;
use Yanis\Apify\Task\Data\Run\Identifier;
use Yanis\Apify\Task\Data\Run\RunResult;

it('should run a new task', function () {
    $taskRunner = $this->apify->taskRunner()->run('foo');
    $identifier = $taskRunner->identifier;
    expect($taskRunner)->toBeInstanceOf(RunResult::class)
        ->status->toBe(Status::READY)
        ->identifier->toBeInstanceOf(Identifier::class)
        ->and((string) $identifier->id)->toBe('aaa')
        ->and((string) $identifier->actId)->toBe('bbb')
        ->and((string) $identifier->userId)->toBe('ccc')
        ->and((string) $identifier->actorTaskId)->toBe('ddd')
        ->and((string) $identifier->buildId)->toBe('eee')
        ->and((string) $identifier->defaultKeyValueStoreId)->toBe('fff')
        ->and((string) $identifier->defaultDatasetId)->toBe('ggg')
        ->and((string) $identifier->defaultRequestQueueId)->toBe('hhh');
});
