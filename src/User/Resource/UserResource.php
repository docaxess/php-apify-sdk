<?php

declare(strict_types=1);

namespace Yanis\Apify\User\Resource;

use Saloon\Http\BaseResource;
use Yanis\Apify\User\Data\User;
use Yanis\Apify\User\Request\MeRequest;

class UserResource extends BaseResource
{
    public function me(): User
    {
        return $this->connector->send(new MeRequest())->dto();
    }
}
