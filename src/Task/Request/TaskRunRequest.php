<?php

declare(strict_types=1);

namespace DocAxess\Apify\Task\Request;

use DocAxess\Apify\Core\ErrorResult;
use DocAxess\Apify\Task\Data\Option\TaskOption;
use DocAxess\Apify\Task\Data\Run\RunResult;
use JsonException;
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

    /**
     * @param  array<string, mixed>|JsonSerializable  $payload
     */
    public function __construct(
        public readonly string $actorTaskId,
        public readonly TaskOption $option,
        public readonly array|JsonSerializable $payload = [],
    ) {}

    protected function defaultQuery(): array
    {
        return $this->option->toParams();
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        if (is_array($this->payload)) {
            return $this->payload;
        }

        /** @var array<string, mixed> */
        return $this->payload->jsonSerialize();
    }

    public function resolveEndpoint(): string
    {
        return sprintf('acts/%s/runs', $this->actorTaskId);
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ErrorResult|RunResult
    {
        if ($response->status() > 299) {
            /** @var array{error: array{message: string, type: string}} $errorData */
            $errorData = $response->json();

            return ErrorResult::make($response->status(), $errorData);
        }

        /** @var array<string, mixed> $json */
        $json = $response->json();

        return RunResult::make($json);
    }
}
