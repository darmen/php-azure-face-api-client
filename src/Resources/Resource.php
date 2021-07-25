<?php

namespace Darmen\AzureFace\Resources;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use function json_decode;

abstract class Resource
{
    /** @var HttpClient */
    protected $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    protected function decodeJsonResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    abstract protected function getUri(): string;
}
