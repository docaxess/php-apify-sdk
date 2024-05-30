<?php

declare(strict_types=1);

namespace Yanis\Apify;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Yanis\Apify\Dataset\Resource\DatasetResource;
use Yanis\Apify\Task\Resource\TaskRunnerResource;
use Yanis\Apify\User\Resource\UserResource;

class ApifyConnector extends Connector
{
    public function __construct(public readonly string $token)
    {
    }

    public function dataset(): DatasetResource
    {
        return new DatasetResource($this);
    }

    public function user(): UserResource
    {
        return new UserResource($this);
    }

    public function taskRunner(): TaskRunnerResource
    {
        return new TaskRunnerResource($this);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.apify.com/v2/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => 'Yanis/ApifyConnector',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }
}
