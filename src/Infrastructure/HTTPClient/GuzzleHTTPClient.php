<?php

namespace App\Infrastructure\HTTPClient;

use App\Application\HTTPClient\HTTPClient;
use GuzzleHttp\ClientInterface;

class GuzzleHTTPClient implements HTTPClient
{
    /** @var ClientInterface */
    private $client;

    private const DEFAULT_OPTIONS = [
        'verify' => false
    ];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $url, array $options): array
    {
        $response = $this->client->request($method, $url, array_merge(self::DEFAULT_OPTIONS, $options));
        return json_decode($response->getBody(), true);
    }
}