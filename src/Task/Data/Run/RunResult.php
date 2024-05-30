<?php

declare(strict_types=1);

namespace Yanis\Apify\Task\Data\Run;

use Yanis\Apify\Core\Type\Status;

readonly class RunResult
{
    public function __construct(
        public Identifier $identifier,
        public Status $status,
    ) {

    }

    /**
     * @param  array<string, mixed>  $state
     */
    public static function make(array $state): self
    {
        $result = $state['data'];

        return new self(
            identifier: Identifier::fromArray($result),
            status: Status::fromString($result['status'] ?? '')
        );
    }
}
