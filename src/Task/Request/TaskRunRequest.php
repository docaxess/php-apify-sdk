<?php

declare(strict_types=1);

namespace DocAxess\Apify\Task\Request;

use DocAxess\Apify\Core\ErrorResult;
use DocAxess\Apify\Task\Data\Option\TaskOption;
use DocAxess\Apify\Task\Data\Run\RunResult;
use JsonSerializable;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Request\CreatesDtoFromResponse;

class TaskRunRequest extends Request implements HasBody
{
    use CreatesDtoFromResponse;
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string $actorTaskId,
        public readonly TaskOption $option,
        public readonly array|JsonSerializable $payload = [],
    ) {
        // when we have empty payload we want to send an empty json object, otherwise apify will reject the request
        $this->body()->setJsonFlags(JSON_FORCE_OBJECT);
    }

    public function defaultQuery(): array
    {
        return $this->option->toParams();
    }

    public function defaultBody(): array
    {
        return is_array($this->payload) ? $this->payload : $this->payload->jsonSerialize();
    }

    public function resolveEndpoint(): string
    {
        return sprintf('acts/%s/runs', $this->actorTaskId);
    }

    public function createDtoFromResponse(Response $response): ErrorResult|RunResult
    {
        if ($response->status() > 299) {
            return ErrorResult::make($response->status(), $response->json());
        }

        return RunResult::make($response->json());
    }
}
