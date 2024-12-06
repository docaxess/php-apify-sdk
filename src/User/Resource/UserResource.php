<?php

declare(strict_types=1);

namespace DocAxess\Apify\User\Resource;

use DocAxess\Apify\User\Data\User;
use DocAxess\Apify\User\Request\MeRequest;
use Saloon\Http\BaseResource;

class UserResource extends BaseResource
{
    public function me(): User
    {
        return $this->connector->send(new MeRequest)->dto();
    }
}
