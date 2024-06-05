<?php

declare(strict_types=1);

namespace DocAxess\Apify\Task\Data\Option;

use DocAxess\Apify\Webhook\Config\WebhookConfig;
use Stringable;

readonly class TaskOption implements Stringable
{
    private const DEFAULT_STATE = [
        'build' => 'latest',
        'timeout' => 60,
        'memory' => 256,
        'webhooks' => [],
    ];

    public function __construct(
        public string $build,
        public int $timeout,
        public int $memory,
        public array $webhooks = [],
    ) {
        foreach ($webhooks as $webhook) {
            assert($webhook instanceof WebhookConfig, 'All webhooks must be of type WebhookConfig::class');
        }
    }

    public static function make(
        ?string $build = null,
        ?int $timeout = null,
        ?int $memory = null,
    ): self {
        return new self(
            build: $build ?? 'latest',
            timeout: $timeout ?? 60,
            memory: $memory ?? 256,
        );
    }

    public function addWebhook(WebhookConfig $webhook): self
    {
        return new self(
            build: $this->build,
            timeout: $this->timeout,
            memory: $this->memory,
            webhooks: [...$this->webhooks, $webhook],
        );
    }

    public function __toString(): string
    {
        return http_build_query($this->toParams());
    }

    public function toParams(): array
    {
        return [
            ...array_filter(
                $this->toArray(),
                fn (mixed $value, string $key) => $value !== null && $value !== self::DEFAULT_STATE[$key],
                ARRAY_FILTER_USE_BOTH
            ),
            ...(! empty($this->webhooks) ? ['webhooks' => $this->encodeWebhook()] : []),
        ];
    }

    public function toArray(): array
    {
        return [
            'build' => $this->build,
            'timeout' => $this->timeout,
            'memory' => $this->memory,
            'webhooks' => $this->webhooks,
        ];
    }

    private function encodeWebhook(): string
    {
        return base64_encode(json_encode($this->webhooks) ?: '');
    }
}
