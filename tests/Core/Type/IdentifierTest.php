<?php

declare(strict_types=1);

use Yanis\Apify\Core\Type\Identifier;

it('should create an identifier', function () {
    $identifier = new Identifier('identifier');

    expect($identifier)->toBeInstanceOf(Identifier::class)
        ->and($identifier->id)->toBe('identifier');
});

it('should create an identifier using the make method', function () {
    $identifier = Identifier::make('identifier');

    expect($identifier)->toBeInstanceOf(Identifier::class)
        ->and($identifier->id)->toBe('identifier');
});

it('should compare two identifiers', fn (string $id1, string $id2, bool $expected) => expect(Identifier::make($id1)->is(Identifier::make($id2)))->toBe($expected)
)->with([
    'same identifier' => ['identifier', 'identifier', true],
    'different identifier' => ['identifier', 'other-identifier', false],
]);

it('should convert an identifier to a string',
    fn () => expect((string) Identifier::make('identifier'))->toBe('identifier')
);

it('should convert an identifier to a json string',
    fn () => expect(json_encode(Identifier::make('identifier')))->toBe('"identifier"')
);
