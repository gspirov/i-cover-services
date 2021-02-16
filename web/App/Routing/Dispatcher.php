<?php

namespace App\Routing;

use App\Base\Request;
use App\Base\Response;
use App\Database\Connection;
use App\Exception\Http\ControllerNotFoundException;
use App\Exception\Http\EmptyResponseException;

class Dispatcher
{
    /**
     * @param Request $request
     * @param Route $route
     * @return Response
     * @throws ControllerNotFoundException|EmptyResponseException
     */
    public function dispatch(Request $request, Route $route): Response
    {
        if (!class_exists($route->getController())) {
            throw new ControllerNotFoundException;
        }

        $controller = $route->getController();
        $pdoInstance = Connection::getInstance($_ENV['MYSQL_DATABASE']);

        $response = call_user_func_array([new $controller($pdoInstance), $route->getAction()], [
                $request
            ]
        );

        if (!$response instanceof Response) {
            throw new EmptyResponseException;
        }

        return $response;
    }
}