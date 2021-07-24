<?php

namespace Darmen\AzureFace;

use GuzzleHttp\Client as HttpClient;

class Client
{
    private const HEADER_SUBSCRIPTION_KEY = 'Ocp-Apim-Subscription-Key';

    /** @var HttpClient|null */
    private $client;

    /** @var array */
    private $httpClientOptions;

    /**
     * Client constructor.
     * @param Configuration $configuration Configuration to use
     * @param HttpClient|null $client Http client to use (defaults to GuzzleHttp)
     * @param array $httpClientOptions Guzzle client options
     */
    public function __construct(Configuration $configuration, HttpClient $client = null, array $httpClientOptions = [])
    {
        $this->initializeHttpClient($configuration, $client, $httpClientOptions);
    }

    /**
     * Initialize an http client.
     *
     * @param Configuration $configuration
     * @param HttpClient|null $client
     * @param array $httpClientOptions
     *
     * @return void
     */
    private function initializeHttpClient(Configuration $configuration, HttpClient $client = null, array $httpClientOptions = []): void
    {
        $httpClientOptions['base_uri'] = rtrim($configuration->getEndpoint(), '/') . '/face/v1.0/';
        $httpClientOptions['headers'][self::HEADER_SUBSCRIPTION_KEY] = $configuration->getSubscriptionKey();

        if ($client === null) {
            $client = new HttpClient($httpClientOptions);
        }

        $this->httpClientOptions = $httpClientOptions;
        $this->client = $client;
    }
}
