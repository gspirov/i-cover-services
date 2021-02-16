<?php

namespace App\Http\Handler;

use App\Exception\Base\EntityNotFoundException;
use App\Exception\Http\AccessDeniedException;
use App\Exception\Http\BadRequestException;
use App\Exception\Http\ControllerNotFoundException;
use App\Exception\Http\HttpAcceptable;
use App\Exception\Http\RequestNotAcceptable;
use App\Http\Renderer\ViewRenderer;
use App\Http\Response;
use Error;
use Exception;
use Throwable;

class ExceptionHandler implements HandlerInterface
{
    /**
     * @param Throwable $exception
     * @throws Exception
     */
    public function handle(Throwable $exception)
    {
        $viewRenderer = new ViewRenderer;

        if ($exception instanceof HttpAcceptable) {
            switch (true) {
                case $exception instanceof BadRequestException:
                    $response = new Response;
                    $response->setContent($exception->getMessage());
                    $response->setStatusCode(Response::BAD_REQUEST);
                    echo $response->send();
                    break;
                case $exception instanceof AccessDeniedException:
                    $response = $viewRenderer->partial('Error/403');
                    $response->setStatusCode(Response::FORBIDDEN);
                    echo $response->send();
                    break;
                case $exception instanceof ControllerNotFoundException:
                    $response = $viewRenderer->partial('Error/404');
                    $response->setStatusCode(Response::NOT_FOUND);
                    echo $response->send();
                    break;
                case $exception instanceof EntityNotFoundException:
                    $response = $viewRenderer->partial('Error/404', ['message' => $exception->getMessage()]);
                    $response->setStatusCode(Response::NOT_FOUND);
                    echo $response->send();
                    break;
                case $exception instanceof RequestNotAcceptable:
                    $response = new Response;
                    $response->setContent($exception->getMessage());
                    $response->setStatusCode(Response::NOT_ACCEPTABLE);
                    echo $response->send();
                    break;
                default:
                    break;
            }

            return;
        }

        if ($exception instanceof Error || $exception instanceof Exception) {
            var_dump($exception->getMessage()); die;
            $response = $viewRenderer->partial('Error/500');
            $response->setStatusCode(Response::INTERNAL_SERVER_ERROR);
            echo $response->send();
            return;
        }
    }
}