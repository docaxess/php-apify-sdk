<?php

declare(strict_types=1);

use DocAxess\Apify\User\Data\Proxy\Group;

it('should create group', function () {
    $group = new Group('name', 'description', 0);
    expect($group->name)->toBe('name')
        ->and($group->description)->toBe('description')
        ->and($group->availableCount)->toBe(0);
});

it('should create group from array', function (array $payload) {
    $group = Group::make($payload);
    expect($group->name)->toBe('foo')
        ->and($group->description)->toBe('bar')
        ->and($group->availableCount)->toBe(2);
})->with([[['name' => 'foo', 'description' => 'bar', 'availableCount' => 2]]]);

it('should throw exception when available count is less than 0', function () {
    new Group('name', 'description', -1);
})->throws(AssertionError::class, 'Available count must be greater than or equal to 0');
