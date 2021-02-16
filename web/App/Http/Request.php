<?php

namespace App\Http;

use App\Exception\Http\ControllerNotFoundException;
use App\Exception\Http\EmptyResponseException;
use App\Exception\Http\RequestNotAcceptable;
use App\Routing\Http\Router;
use App\Base\Request as BaseRequest;
use Exception;

class Request extends BaseRequest
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    /**
     * @var Router $router
     */
    private Router $router;

    /**
     * Read-only property for obtaining headers from the incoming request.
     * @var HeaderBag $headers
     */
    private HeaderBag $headers;

    /**
     * Request constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->router = new Router;
        $this->headers = new HeaderBag;

        foreach (getallheaders() as $header => $value) {
            $this->headers->offsetSet(
                $header,
                new Header($header, $value)
            );
        }

        $this->headers->setReadOnly(true);
    }

    /**
     * @throws ControllerNotFoundException
     * @throws EmptyResponseException
     * @throws RequestNotAcceptable
     */
    public function handle()
    {
        $response = $this->router->parseRequest($this);
        echo $response->send();
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $_POST;
    }

    public function getQuery(): array
    {
        return $_GET;
    }

    /**
     * @param string $method
     * @return bool
     */
    public function isMethod(string $method): bool
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }

    /**
     * @return HeaderBag
     */
    public function getHeaders(): HeaderBag
    {
        return $this->headers;
    }
}