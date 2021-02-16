<?php

namespace App\Routing\Base;

use App\Base\Response;
use App\Routing\Dispatcher;
use App\Http\Request as BaseRequest;

abstract class Router
{
    /**
     * @var Dispatcher $dispatcher
     */
    protected Dispatcher $dispatcher;

    /**
     * @var RoutesCollection $routes
     */
    protected RoutesCollection $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->dispatcher = new Dispatcher;
        $this->routes = new RoutesCollection;
        $this->mapRoutes();
    }

    abstract protected function mapRoutes();

    /**
     * @param BaseRequest $request
     * @return Response
     */
    abstract public function parseRequest(BaseRequest $request): Response;

    /**
     * @param string $needle
     * @return string
     */
    protected function camelCaseToDashes(string $needle): string
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $needle));
    }
}