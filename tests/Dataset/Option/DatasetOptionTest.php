<?php

use DocAxess\Apify\Core\Type\Identifier;
use DocAxess\Apify\Dataset\Option\DatasetOption;
use DocAxess\Apify\Dataset\Option\FormatType;
use DocAxess\Apify\Dataset\Option\Pagination;

it('should create a dataset option with default values', function () {
    $identifier = Identifier::make('my-dataset');
    $option = DatasetOption::fromId($identifier);

    expect($option->identifier)->toBe($identifier)
        ->and($option->formatType)->toBe(FormatType::default())
        ->and($option->pagination->isDisabled())->toBeTrue();
});

it('should create a dataset option with custom values', function (string $formatType, int $limit, int $offset) {
    $identifier = Identifier::make('my-dataset');
    $formatType = FormatType::fromString($formatType);
    $pagination = Pagination::enabled($limit, $offset);
    $option = DatasetOption::make($identifier, $formatType, $pagination);

    expect($option->identifier)->toBe($identifier)
        ->and($option->formatType)->toBe($formatType)
        ->and($option->pagination)->toBe($pagination);
})->with([
    'json', 'jsonl', 'csv', 'xml', 'html', 'xlsx', 'rss',
])->with([
    100, 200, 300,
])->with([
    0, 100, 200,
]);

it('should json serialize', function () {
    $identifier = Identifier::make('my-dataset');
    $option = DatasetOption::fromId($identifier);

    expect(json_encode($option))->toBe('{"identifier":"my-dataset","formatType":"json","pagination":{"limit":null,"offset":null}}');
});

it('should transform to query  params', function (DatasetOption $option, array $params) {
    expect($option->toParams())->toBe($params);
})->with([
    [DatasetOption::fromId(Identifier::make('foo')), ['clean' => true]],
    [DatasetOption::make(Identifier::make('foo'), FormatType::JSON, Pagination::enabled(100, 0)), ['clean' => true, 'limit' => 100, 'offset' => 0]],
    [DatasetOption::make(Identifier::make('foo'), FormatType::XLSX, Pagination::disabled()), ['clean' => true, 'format' => 'xlsx']],
]);

it('should throw exception when dtoType is wrong', function () {
    DatasetOption::fromId(Identifier::make('foo'), 'wrong');
})->throws(InvalidArgumentException::class);
