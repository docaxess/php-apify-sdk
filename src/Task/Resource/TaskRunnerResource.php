<?php

declare(strict_types=1);

namespace DocAxess\Apify\Task\Resource;

use DocAxess\Apify\Core\ErrorResult;
use DocAxess\Apify\Task\Data\Option\TaskOption;
use DocAxess\Apify\Task\Data\Run\RunResult;
use DocAxess\Apify\Task\Request\TaskRunRequest;
use JsonSerializable;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class TaskRunnerResource extends BaseResource
{
    /**
     * @param  array<string, mixed>|JsonSerializable  $payload
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function run(
        string $actorTaskId,
        ?TaskOption $option = null,
        array|JsonSerializable $payload = []
    ): RunResult|ErrorResult {
        /** @var RunResult|ErrorResult */
        return $this->connector->send(new TaskRunRequest(
            actorTaskId: $actorTaskId,
            option: $option ?? TaskOption::make(),
            payload: $payload
        ))->dto();
    }
}
