<?php

declare(strict_types=1);

namespace DocAxess\Apify\Webhook\Config;

use DocAxess\Apify\Webhook\Event\EventType;

readonly class WebhookConfig implements \JsonSerializable
{
    /**
     * @param  EventType[]  $eventTypes
     */
    public function __construct(
        public array $eventTypes,
        public string $url,
        public ?string $template = null,
        public ?string $headers = null,
    ) {
        foreach ($this->eventTypes as $eventType) {
            assert($eventType instanceof EventType, 'All event types must be of type EventType::class');
        }
    }

    /**
     * Creates an instance of the class for a specific event.
     *
     * @param  EventType  $eventType  The event type for the instance.
     * @param  string  $url  The associated URL.
     * @param  string|null  $template  The optional template.
     * @param  array<string, string>|string|null  $headers  The optional headers as associative array, string or null.
     * @return self Returns an instance of the class.
     */
    public static function forEvent(
        EventType $eventType,
        string $url,
        ?string $template = null,
        null|array|string $headers = null,
    ): self {
        if (is_array($headers)) {
            $headers = json_encode($headers);
        }

        // @phpstan-ignore-next-line
        return new self([$eventType], $url, $template, $headers);
    }

    public function addEventType(EventType $eventType): self
    {
        return new self(
            [...$this->eventTypes, $eventType],
            $this->url,
            $this->template,
            $this->headers
        );
    }

    /**
     * Adds a new header to the existing headers.
     *
     * @param  string  $key  The header key.
     * @param  string  $value  The header value.
     * @return self Returns a new instance with the added header.
     */
    public function addHeader(string $key, string $value): self
    {
        $existingHeaders = [];
        if ($this->headers !== null) {
            $decoded = json_decode($this->headers, true);
            if (is_array($decoded)) {
                $existingHeaders = $decoded;
            }
        }

        $encodedHeaders = json_encode([...$existingHeaders, $key => $value]);
        $headers = $encodedHeaders !== false ? $encodedHeaders : null;

        return new self(
            $this->eventTypes,
            $this->url,
            $this->template,
            $headers
        );
    }

    public function addBearerToken(string $token): self
    {
        return $this->addHeader('Authorization', 'Bearer '.$token);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'eventTypes' => $this->eventTypes,
            'requestUrl' => $this->url,
            'payloadTemplate' => $this->template,
            'headersTemplate' => $this->headers,
        ]);
    }
}
