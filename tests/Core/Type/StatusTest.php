<?php

declare(strict_types=1);

use DocAxess\Apify\Core\Type\Status;

dataset('status', [
    [Status::READY, 'READY'],
    [Status::RUNNING, 'RUNNING'],
    [Status::SUCCEEDED, 'SUCCEEDED'],
    [Status::FAILED, 'FAILED'],
    [Status::TIMING_OUT, 'TIMING-OUT'],
    [Status::TIMED_OUT, 'TIMED-OUT'],
    [Status::ABORTING, 'ABORTING'],
    [Status::ABORTED, 'ABORTED'],
]);

it('Should return the correct status from string',
    fn (Status $expected, string $value) => expect(Status::fromString($value))->toBe($expected))
    ->with('status');

it('should compare equal statuses',
    fn (Status $status1, Status $status2, bool $expected) => expect($status1->is($status2))->toBe($expected))
    ->with([
        [Status::READY, Status::READY, true],
        [Status::READY, Status::RUNNING, false],
    ]);

it('should throw an exception for invalid status',
    fn () => Status::fromString('INVALID'))
    ->throws(InvalidArgumentException::class, 'Invalid status: INVALID');
