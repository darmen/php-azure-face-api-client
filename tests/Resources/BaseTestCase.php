<?php

namespace Darmen\AzureFace\Tests\Resources;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    protected function emptyResponse(): Response
    {
        return new Response();
    }

    protected function emptyJsonResponse(): Response
    {
        return new Response(200, [], json_encode([]));
    }

    protected function emptyResource() {
        return fopen('php://memory', 'r+');
    }
}
