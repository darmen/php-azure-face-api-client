<?php

namespace Darmen\AzureFace\Http;

use Darmen\AzureFace\Exceptions\ApiErrorException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Middleware
{
    public static function wrapApiErrors(): callable
    {
        return static function (callable $handler) {
            return static function (RequestInterface $request, array $options) use ($handler) {
                return $handler($request, $options)->then(
                    static function (ResponseInterface $response) use ($request) {
                        $code = $response->getStatusCode();
                        if ($code >= 400) {
                            throw ApiErrorException::create($request, $response);
                        }
                    }
                );
            };
        };
    }
}
