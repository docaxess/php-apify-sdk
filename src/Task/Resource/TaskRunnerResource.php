<?php

declare(strict_types=1);

namespace DocAxess\Apify\Task\Resource;

use DocAxess\Apify\Core\ErrorResult;
use DocAxess\Apify\Task\Data\Option\TaskOption;
use DocAxess\Apify\Task\Data\Run\RunResult;
use DocAxess\Apify\Task\Request\TaskRunRequest;
use JsonSerializable;
use Saloon\Http\BaseResource;

class TaskRunnerResource extends BaseResource
{
    public function run(
        string $actorTaskId,
        ?TaskOption $option = null,
        array|JsonSerializable $payload = []
    ): RunResult|ErrorResult {
        return $this->connector->send(new TaskRunRequest(
            actorTaskId: $actorTaskId,
            option: $option ?? TaskOption::make(),
            payload: $payload
        ))->dto();
    }
}
