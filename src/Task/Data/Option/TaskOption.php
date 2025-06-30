<?php

declare(strict_types=1);

namespace DocAxess\Apify\Task\Data\Option;

use DocAxess\Apify\Webhook\Config\WebhookConfig;
use Stringable;

readonly class TaskOption implements Stringable
{
    private const array DEFAULT_STATE = [
        'build' => 'latest',
        'timeout' => 60,
        'memory' => 256,
        'webhooks' => [],
    ];

    /**
     * @param  WebhookConfig[]  $webhooks
     */
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

    /**
     * Create a new instance of the class.
     *
     * @param  string|null  $build  The build version, defaults to 'latest' if not provided.
     * @param  int|null  $timeout  The timeout value in seconds, defaults to 60 if not provided.
     * @param  int|null  $memory  The memory limit in megabytes, defaults to 256 if not provided.
     * @return self Returns an instance of the class.
     */
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

    /**
     * Adds a webhook configuration to the collection.
     *
     * @param  WebhookConfig  $webhook  The webhook configuration to be added.
     * @return self The current instance for method chaining.
     */
    public function addWebhook(WebhookConfig $webhook): self
    {
        return new self(
            build: $this->build,
            timeout: $this->timeout,
            memory: $this->memory,
            webhooks: [...$this->webhooks, $webhook],
        );
    }

    /**
     * Converts the object to a query string representation.
     *
     * @return string The query string representation of the object.
     */
    public function __toString(): string
    {
        return http_build_query($this->toParams());
    }

    /**
     * Converts the object to an array of parameters, filtering out default or null values,
     * and includes encoded webhook data if available.
     *
     * @return array<string, mixed> The filtered array of parameters.
     */
    public function toParams(): array
    {
        return [
            ...array_filter(
                $this->toArray(),
                fn (mixed $value, string $key): bool => $value !== null && $value !== self::DEFAULT_STATE[$key],
                ARRAY_FILTER_USE_BOTH
            ),
            ...(empty($this->webhooks) ? [] : ['webhooks' => $this->encodeWebhook()]),
        ];
    }

    /**
     * Converts the object to an associative array representation.
     *
     * @return array<string, mixed> The array representation of the object, including build, timeout, memory, and webhooks.
     */
    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'build' => $this->build,
            'timeout' => $this->timeout,
            'memory' => $this->memory,
            'webhooks' => $this->webhooks,
        ];
    }

    /**
     * Encodes the webhooks data into a base64-encoded JSON string.
     *
     * @return string The base64-encoded JSON representation of the webhooks.
     */
    private function encodeWebhook(): string
    {
        return base64_encode(json_encode($this->webhooks) ?: '');
    }
}
