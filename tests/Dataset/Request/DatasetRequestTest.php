<?php

declare(strict_types=1);

use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\Dataset\Item\Item;

it('should return result for case', function (Identifier $identifier, array $expected) {
    $response = $this->apify->dataset()->getJson($identifier);
    expect($response)->toBe($expected);
})->with([
    [Identifier::make('case-1'), []],
    [Identifier::make('case-2'), [
        ['key' => 'bar'],
        ['key' => 'foo'],
        ['key' => 'baz'],
    ]],
]);

it('should transform response to DTO', function () {
    $objet = new class([]) implements Item
    {
        public function __construct(public array $state) {}

        public static function fromArray(array $state): static
        {
            return new self($state);
        }
    };
    $results = $this->apify->dataset()->getJson(Identifier::make('case-2'), $objet::class);
    expect($results)->toBeArray()->and($results)->each->toBeInstanceOf($objet::class);
});
