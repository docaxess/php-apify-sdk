<?php

declare(strict_types=1);

use DocAxess\Apify\User\Data\Proxy\Group;
use DocAxess\Apify\User\Data\Proxy\Proxy;
use DocAxess\Apify\User\Data\User;

it('should return the current user', function () {
    $user = $this->apify->user()->me();

    expect($user)->toBeInstanceOf(User::class)
        ->username->toBe('john.doe')
        ->email->toBe('john.doe@organisation.com')
        ->id->toBe('QxexDwdgrlp')
        ->organizationOwnerUserId->toBe('xxxxxxxx')
        ->isPaying->toBeTrue()
        ->proxy->toBeInstanceOf(Proxy::class)
        ->and($user->proxy->password)->toBe('apify_proxy_pewkow234weklfewf0sdc')
        ->and($user->proxy->groups)->toBeArray()
        ->and($user->proxy->groups)->toHaveCount(4)
        ->and($user->proxy->groups[0])->toBeInstanceOf(Group::class);
});
