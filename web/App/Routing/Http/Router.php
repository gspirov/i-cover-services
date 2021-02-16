<?php

namespace App\Routing\Http;

use App\Base\Request;
use App\Base\Response;
use App\Exception\Http\ControllerNotFoundException;
use App\Exception\Http\EmptyResponseException;
use App\Exception\Http\RequestNotAcceptable;
use App\Http\AbstractController;
use App\Routing\Base\Router as BaseRouter;
use App\Routing\Route;
use ReflectionClass;
use ReflectionException;

class Router extends BaseRouter
{
    /**
     * Router constructor.
     * @throws ReflectionException
     */
    public function __construct()
    {
        parent::__construct();

        /* @var Route[] $predefinedRoutes */
        $predefinedRoutes = require_once APP_PATH . '/App/Config/routes.php';

        foreach ($predefinedRoutes as $path => $route) {
            if (!class_exists($route->getController())) {
                continue;
            }

            if (!(new ReflectionClass($route->getController()))->hasMethod($route->getAction())) {
                continue;
            }

            $this->routes->offsetSet($path, $route);
        }
    }

    /**
     * @throws ReflectionException
     */
    protected function mapRoutes()
    {
        $controllers = glob(APP_PATH . '/App/Controller/*.php');

        foreach ($controllers as $controller) {
            list(, $controllerName) = explode('/App/Controller/', $controller);
            $namespaced = sprintf(
                'App\\Controller\\%s',
                str_replace('.php', '', $controllerName)
            );

            if (class_exists($namespaced)) {
                $reflection = new ReflectionClass($namespaced);

                foreach ($reflection->getMethods() as $action) {
                    if ($action->getDeclaringClass()->getName() === AbstractController::class || $action->isConstructor()) {
                        continue;
                    }

                    $extractedControllerName = str_replace('Controller.php', '', $controllerName);

                    $parsedControllerName = preg_match('/[A-Z]/', $extractedControllerName)
                                            ? $this->camelCaseToDashes($extractedControllerName)
                                            : $extractedControllerName;

                    $parsedActionName = preg_match('/[A-Z]/', $action->getName())
                                        ? $this->camelCaseToDashes($action->getName())
                                        : $action->getName();

                    $route = new Route($reflection->getName(), $action->getName());
                    $this->routes->offsetSet(
                        sprintf(
                            '/%s/%s',
                            $parsedControllerName,
                            $parsedActionName
                        ),
                        $route
                    );
                }
            }
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ControllerNotFoundException
     * @throws EmptyResponseException
     * @throws RequestNotAcceptable
     */
    public function parseRequest(Request $request): Response
    {
        if (!$request instanceof \App\Http\Request) {
            throw new RequestNotAcceptable;
        }

        $acceptableHeaders = explode(',', $request->getHeaders()->offsetGet('Accept'));

        if (array_search('Accept: text/html', $acceptableHeaders) === false) {
            throw new RequestNotAcceptable;
        }

        if (!$this->routes->offsetExists($request->getRequestPath())) {
            throw new ControllerNotFoundException;
        }

        return $this->dispatcher->dispatch(
            $request,
            $this->routes->offsetGet($request->getRequestPath())
        );
    }
}