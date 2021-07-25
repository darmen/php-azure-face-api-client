<?php

namespace Darmen\AzureFace\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;
use function floor;
use function sprintf;

class ApiErrorException extends RuntimeException
{
    /** @var RequestInterface */
    private $request;

    /** @var ResponseInterface */
    private $response;

    public function __construct(string $message, RequestInterface $request, ResponseInterface $response, Throwable $previous = null)
    {
        $code = $response ? $response->getStatusCode() : 0;

        $this->message = $message;
        $this->request = $request;
        $this->response = $response;

        parent::__construct($message, $code, $previous);
    }

    public static function create(RequestInterface $request, ResponseInterface $response = null, Throwable $previous = null): self
    {
        $level = (int)floor($response->getStatusCode() / 100);

        if ($level === 4) {
            $label = 'Client error';
        } elseif ($level === 5) {
            $label = 'Server error';
        } else {
            $label = 'Unsuccessful request';
        }

        $message = sprintf(
            '%s: `%s %s` resulted in a `%s %s` response',
            $label,
            $request->getMethod(),
            $request->getUri(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        return new self($message, $request, $response, $previous);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
