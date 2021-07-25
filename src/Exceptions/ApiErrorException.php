<?php

namespace Darmen\AzureFace\Exceptions;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use function json_decode;

class ApiErrorException extends RuntimeException
{
    /** @var string */
    private $errorCode;

    /** @var string */
    private $errorMessage;

    public function __construct(string $errorCode, string $errorMessage, ResponseInterface $response = null)
    {
        $message = 'Api error: ' . $errorCode . ' ' . $errorMessage;

        parent::__construct($message, $response ? $response->getStatusCode() : 0);

        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    public static function create(ResponseInterface $response): self
    {
        $responseJson = json_decode($response->getBody()->getContents(), true);
        $error = $responseJson['error'];

        return new self($error['code'], $error['message'], $response);
    }

    /** @return string */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /** @return string */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
