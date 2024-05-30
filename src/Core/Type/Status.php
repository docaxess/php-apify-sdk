<?php

declare(strict_types=1);

namespace Yanis\Apify\Core\Type;

use InvalidArgumentException;

/**
 * @source https://github.com/apify/apify-shared-js/blob/master/packages/consts/src/consts.ts#L27
 */
enum Status: string
{
    case READY = 'READY'; // started but not allocated to any worker yet
    case RUNNING = 'RUNNING'; // running on worker
    case SUCCEEDED = 'SUCCEEDED'; // finished and all good
    case FAILED = 'FAILED'; // run or build failed
    case TIMING_OUT = 'TIMING-OUT'; // timing out now
    case TIMED_OUT = 'TIMED-OUT'; // timed out
    case ABORTING = 'ABORTING'; // being aborted by user
    case ABORTED = 'ABORTED'; // aborted by user

    public static function fromString(string $value): self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        throw new InvalidArgumentException("Invalid status: $value");
    }

    public function is(Status $status): bool
    {
        return $this === $status;
    }
}
