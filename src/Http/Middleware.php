<?php

namespace Darmen\AzureFace\Http;

use Darmen\AzureFace\Exceptions\ApiErrorException;
use Psr\Http\Message\ResponseInterface;

class Middleware
{
    public static function wrapApiErrors(): callable
    {
        return \GuzzleHttp\Middleware::mapResponse(function (ResponseInterface $response) {
            $code = $response->getStatusCode();
            if ($code >= 400) {
                throw ApiErrorException::create($response);
            }

            return $response;
        });
    }
}
