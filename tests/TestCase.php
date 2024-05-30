<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use RuntimeException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use Throwable;
use Yanis\Apify\ApifyConnector;

class TestCase extends \PHPUnit\Framework\TestCase
{
    private const FIXTURES_PATH = __DIR__.'/fixtures';

    private const EXPECTED_BASE_URL = 'https://api.apify.com';

    protected ApifyConnector $apify;

    public function fixture(string $path): array
    {
        return json_decode(file_get_contents(self::FIXTURES_PATH."/$path.json"), true);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->apify = new ApifyConnector('xxxx');

        $mockClient = new MockClient([
            function (PendingRequest $request): MockResponse {
                if (! str_starts_with($request->getUrl(), self::EXPECTED_BASE_URL)) {
                    return MockResponse::make()->throw(
                        fn (Request $guzzleRequest): Throwable => new ConnectException('Wrong base-url.', $guzzleRequest)
                    );
                }
                // Get the path and query parameters from the request
                $body = $this->loadJsonResponseFromFile(
                    path: parse_url($request->getUrl(), PHP_URL_PATH),
                    data: [
                        ...($request->body()?->all() ?? []),
                        ...($request->query()?->all() ?? []),
                    ]
                );

                return MockResponse::make($body, 200, [
                    'Content-Type' => 'application/json',
                ]);
            },
        ]);

        $this->apify->withMockClient($mockClient);
    }

    private function loadJsonResponseFromFile(string $path, array $data): string
    {
        $path = str_replace('.json', '', $path);
        if ($path[0] === '/') {
            $path = substr($path, 1);
        }
        // add get parameters to the path
        $path .= ! empty($data) ? '?'.http_build_query($data) : '';

        $filePath = self::FIXTURES_PATH."/$path.json";

        if (! file_exists($filePath)) {
            throw new RuntimeException("Fixture file not found: $filePath");
        }

        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new RuntimeException("Failed to read fixture file: $filePath");
        }

        $content = json_decode($content, true);

        if ($content === null) {
            throw new RuntimeException("Failed to decode JSON from fixture file: $filePath");
        }

        return json_encode($content, JSON_PRETTY_PRINT);
    }
}
