<?php

declare(strict_types=1);

namespace DocAxess\Apify\User\Request;

use DocAxess\Apify\User\Data\User;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;

class MeRequest extends Request
{
    use CreatesDtoFromResponse;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'users/me';
    }

    public function createDtoFromResponse(Response $response): User
    {
        return User::make($response->json());
    }
}
