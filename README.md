# Apify SDK for PHP

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/laravel-imgix.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/laravel-imgix)
[![MIT License](https://img.shields.io/github/license/Astrotomic/laravel-imgix.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/laravel-imgix/blob/master/LICENSE)

## Installation

```bash
composer require yanis/php-apify-sdk
```

## Token generation

You can generate a token by following the instructions: 
 - Go to the [Apify Console](https://console.apify.com/)
 - Go to settings > Integrations
 - Click on the "+ Add token" button

You can find more detail on the [Apify Documentation](https://docs.apify.com/platform/integrations/api#api-token)

## Usage

First you need to create a new instance of the ApifyConnector class and pass your token as a parameter.
```php
use Yanis\Apify\ApifyConnector;

$apify = new ApifyConnector('YOUR_APIFY_TOKEN');
```

From this point you can use the different methods available in the class.

### Get information about the user
```php
$user = $apify->user()->me(); 
```

### Start a new actor run
```php
use Yanis\Apify\ApifyConnector;
use Yanis\Apify\Task\Data\Option\TaskOption;

// The ID of the actor you want to run, it can be found in the actor's URL
// or you can use the slug like 'yanis~actor-name'
$actorId = 'YOUR_ACTOR_ID'; 
$apify = new ApifyConnector('YOUR_APIFY_TOKEN');
$run = $apify->taskRunner()->run($actorId);

// it also possible to pass configuration options and input data
$config = new TaskOption(
    build: '1.2.3', 
    timeout: 300, 
    memory: 2048, 
);
$run = $apify->taskRunner()->run($actorId, $config, [
    'key' => 'value' // input data to pass to the actor run
]);
```

### Add a webhook to an actor
```php
use Yanis\Apify\ApifyConnector;
use Yanis\Apify\Task\Data\Option\TaskOption;
use Yanis\Apify\Webhook\Config\WebhookConfig;
use Yanis\Apify\Webhook\Event\EventType;

$actorId = 'YOUR_ACTOR_ID'; 
$apify = new ApifyConnector('YOUR_APIFY_TOKEN');

$config = new TaskOption();
$config->addWebhook(WebhookConfig::forEvent(EventType::RUN_SUCCEEDED, 'https://your-webhook-url.com'));

$run = $apify->taskRunner()->run($actorId, $config);
```

Webhook events detail can be parsed with the provided object.

```php
use Yanis\Apify\Webhook\Data\EventResult;

$eventResult = EventResult::fromArray(request()->all());
```

### Get Dataset
```php
use Yanis\Apify\ApifyConnector;
use Yanis\Apify\Webhook\Data\EventResult;
use Yanis\Apify\Core\Type\Identifier;

$eventResult = EventResult::fromArray(request()->all());

$apify = new ApifyConnector('YOUR_APIFY_TOKEN');
$results = $apify->dataset()->getJson($eventResult->datasetId);

// or if you know the dataset ID
$results = $apify->dataset()->getJson(Identifier::make('YOUR_DATASET_ID'));
```

By default, the dataset will return associative array, but you can also give the DTO class to return for each item.
It should implement the `Yanis\Apify\Dataset\Item\Item` interface.
```php
use Yanis\Apify\ApifyConnector;
use Yanis\Apify\Webhook\Data\EventResult;
use Yanis\Apify\Core\Type\Identifier;

$apify = new ApifyConnector('YOUR_APIFY_TOKEN');
$results = $apify->dataset()->getJson(Identifier::make('YOUR_DATASET_ID'), YourDtoForItem::class);
```

## Disclaimer

### Affiliation
This package is not an official package from Apify. It is a community package that uses the Apify API. It is not affiliated with Apify in any way.

### API Coverage
This package does not cover all the Apify API, and was primarily built to cover our own use cases.
It is a work in progress and will be updated over time. 
If you need a specific feature, feel free to open an issue or a pull request.

