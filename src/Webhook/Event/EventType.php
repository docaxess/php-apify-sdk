<?php

declare(strict_types=1);

namespace Yanis\Apify\Webhook\Event;

use InvalidArgumentException;

/**
 * @source https://docs.apify.com/platform/integrations/webhooks/events#run-event-types
 */
enum EventType: string
{
    case BUILD_CREATED = 'ACTOR.BUILD.CREATED'; // new Actor build has been created.
    case BUILD_SUCCEEDED = 'ACTOR.BUILD.SUCCEEDED'; // Actor build finished with the status SUCCEEDED.
    case BUILD_FAILED = 'ACTOR.BUILD.FAILED'; // Actor build finished with the status FAILED.
    case BUILD_ABORTED = 'ACTOR.BUILD.ABORTED'; // Actor build finished with the status ABORTED.
    case BUILD_TIMED_OUT = 'ACTOR.BUILD.TIMED_OUT'; // Actor build finished with the status TIMED-OUT.

    case RUN_CREATED = 'ACTOR.RUN.CREATED'; // new Actor run has been created.
    case RUN_SUCCEEDED = 'ACTOR.RUN.SUCCEEDED'; // Actor run finished with status SUCCEEDED.
    case RUN_FAILED = 'ACTOR.RUN.FAILED'; // Actor run finished with status FAILED.
    case RUN_ABORTED = 'ACTOR.RUN.ABORTED'; // Actor run finished with status ABORTED.
    case RUN_TIMED_OUT = 'ACTOR.RUN.TIMED_OUT'; // Actor run finished with status TIMED-OUT.
    case RUN_RESURRECTED = 'ACTOR.RUN.RESURRECTED'; // Actor run has been resurrected.

    public static function fromString(string $value): self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        throw new InvalidArgumentException("Invalid event type: $value");
    }
}
