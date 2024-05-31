<?php

declare(strict_types=1);

use DocAxess\Apify\User\Data\Proxy\Proxy;

dataset('proxy', [
    [
        [
            'password' => 'password',
            'groups' => [
                [
                    'name' => 'group1',
                    'description' => 'foo',
                    'availableCount' => 10,
                ],
                [
                    'name' => 'group2',
                    'description' => 'bar',
                    'availableCount' => 20,
                ],
            ],
        ],
    ],
]);

it('should make object from array', function (array $state) {
    $proxy = Proxy::make($state);
    expect($proxy->password)->toBe('password')
        ->and($proxy->groups)->toBeArray()
        ->and($proxy->groups)->toHaveCount(2);
})->with('proxy');

it('should generate proxy url', function (array $state, ?string $group, string $username) {
    $proxy = Proxy::make($state);
    expect($proxy->url($group))->toBe(sprintf('http://%s:password@proxy.apify.com:8000', $username));
})
    ->with('proxy')
    ->with([
        ['group1', 'group1'],
        ['group2', 'group2'],
        ['unknown_group', 'auto'],
        [null, 'auto'],
    ]);
