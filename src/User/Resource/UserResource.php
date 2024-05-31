<?php

declare(strict_types=1);

namespace DocAxess\Apify\User\Resource;

use Saloon\Http\BaseResource;
use DocAxess\Apify\User\Data\User;
use DocAxess\Apify\User\Request\MeRequest;

class UserResource extends BaseResource
{
    public function me(): User
    {
        return $this->connector->send(new MeRequest())->dto();
    }
}
