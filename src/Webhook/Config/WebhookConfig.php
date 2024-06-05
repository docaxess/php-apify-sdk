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
        return new self([...$this->eventTypes, $eventType], $this->url, $this->template);
    }

    public function addHeader(string $key, string $value): self
    {
        // @phpstan-ignore-next-line
        return new self($this->eventTypes, $this->url, $this->template, json_encode(
            [
                ...json_decode($this->headers ?? '[]', true),
                $key => $value,
            ])
        );
    }

    public function addBearerToken(string $token): self
    {
        return $this->addHeader('Authorization', 'Bearer '.$token);
    }

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
