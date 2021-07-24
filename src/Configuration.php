<?php

namespace Darmen\AzureFace;

class Configuration
{
    /**
     * Azure endpoint.
     *
     * @var string
     */
    private $endpoint;

    /**
     * Azure subscription key.
     *
     * @var string
     */
    private $subscriptionKey;

    public function __construct(string $endpoint, string $subscriptionKey)
    {
        $this->subscriptionKey = $subscriptionKey;
        $this->endpoint = $endpoint;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getSubscriptionKey(): string
    {
        return $this->subscriptionKey;
    }
}
