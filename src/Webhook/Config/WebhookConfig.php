<?php

declare(strict_types=1);

namespace Yanis\Apify\Webhook\Config;

use Yanis\Apify\Webhook\Event\EventType;

readonly class WebhookConfig implements \JsonSerializable
{
    /**
     * @param  EventType[]  $eventTypes
     */
    public function __construct(
        public array $eventTypes,
        public string $url,
        public ?string $template = null,
    ) {
        foreach ($this->eventTypes as $eventType) {
            assert($eventType instanceof EventType, 'All event types must be of type EventType::class');
        }
    }

    public static function forEvent(
        EventType $eventType,
        string $url,
        ?string $template = null,
    ): self {
        return new self([$eventType], $url, $template);
    }

    public function addEventType(EventType $eventType): self
    {
        return new self([...$this->eventTypes, $eventType], $this->url, $this->template);
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'eventTypes' => $this->eventTypes,
            'requestUrl' => $this->url,
            'payloadTemplate' => $this->template,
        ]);
    }
}
