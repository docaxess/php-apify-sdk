<?php

declare(strict_types=1);

namespace DocAxess\Apify\User\Data;

use DocAxess\Apify\User\Data\Proxy\Proxy;

readonly class User
{
    public function __construct(
        public string $id,
        public string $username,
        public string $email,
        public Proxy $proxy,
        public bool $isPaying,
        public string $organizationOwnerUserId
    ) {}

    /**
     * @param  array<string, mixed>  $state
     */
    public static function make(array $state): self
    {
        $user = $state['data'];

        return new self(
            id: $user['id'],
            username: $user['username'],
            email: $user['email'],
            proxy: Proxy::make($user['proxy']),
            isPaying: $user['isPaying'],
            organizationOwnerUserId: $user['organizationOwnerUserId']
        );
    }
}
