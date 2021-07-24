<?php

namespace Darmen\AzureFace\Resources;

use GuzzleHttp\Client as HttpClient;

abstract class Resource
{
    /** @var HttpClient */
    protected $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    abstract protected function getUri(): string;
}
