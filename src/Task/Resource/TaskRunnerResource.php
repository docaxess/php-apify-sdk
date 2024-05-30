<?php

declare(strict_types=1);

namespace Yanis\Apify\Task\Resource;

use JsonSerializable;
use Saloon\Http\BaseResource;
use Yanis\Apify\Task\Data\Option\TaskOption;
use Yanis\Apify\Task\Data\Run\RunResult;
use Yanis\Apify\Task\Request\TaskRunRequest;

class TaskRunnerResource extends BaseResource
{
    public function run(
        string $actorTaskId,
        ?TaskOption $option = null,
        array|JsonSerializable $payload = []
    ): RunResult {
        return $this->connector->send(new TaskRunRequest(
            actorTaskId: $actorTaskId,
            option: $option ?? TaskOption::make(),
            payload: $payload
        ))->dto();
    }
}
