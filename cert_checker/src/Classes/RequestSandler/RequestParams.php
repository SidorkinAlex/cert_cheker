<?php

namespace Sidalex\CertChecker\Classes\RequestSandler;

use http\Message\Body;

class RequestParams
{
    protected string $uri;
    protected array $headers = [];
    protected string $body = '';

    public function __construct(string $uri, array $headers = [], string $body = '')
    {
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

}