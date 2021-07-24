<?php

namespace Darmen\AzureFace;

use Darmen\AzureFace\Resources\LargeFaceList;
use GuzzleHttp\Client as HttpClient;

/**
 * @method LargeFaceList largeFaceList()
 * @package Darmen\AzureFace
 */
class Client
{
    private const HEADER_SUBSCRIPTION_KEY = 'Ocp-Apim-Subscription-Key';

    /** @var HttpClient|null */
    private $httpClient;

    /** @var array */
    private $httpClientOptions;

    /**
     * Client constructor.
     * @param string $endpoint Azure Cognitive Services endpoint
     * @param string $subscriptionKey Azure Cognitive Services subscription key
     * @param HttpClient|null $httpClient Http client to use (defaults to GuzzleHttp)
     * @param array $httpClientOptions Guzzle client options
     */
    public function __construct(string $endpoint, string $subscriptionKey, HttpClient $httpClient = null, array $httpClientOptions = [])
    {
        $this->initializeHttpClient($endpoint, $subscriptionKey, $httpClient, $httpClientOptions);
    }

    /**
     * Initialize an http client.
     *
     * @param string $endpoint
     * @param string $subscriptionKey
     * @param HttpClient|null $httpClient
     * @param array $httpClientOptions
     *
     * @return void
     */
    private function initializeHttpClient(string $endpoint, string $subscriptionKey, HttpClient $httpClient = null, array $httpClientOptions = []): void
    {
        $httpClientOptions['base_uri'] = rtrim($endpoint, '/') . '/face/v1.0/';
        $httpClientOptions['headers'][self::HEADER_SUBSCRIPTION_KEY] = $subscriptionKey;

        if ($httpClient === null) {
            $httpClient = new HttpClient($httpClientOptions);
        }

        $this->httpClientOptions = $httpClientOptions;
        $this->httpClient = $httpClient;
    }

    public function __call($name, $arguments)
    {
        $resource = 'Darmen\\AzureFace\\Resources\\' . ucfirst($name);

        return new $resource($this->httpClient, ...$arguments);
    }
}
