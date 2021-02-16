<?php

namespace App\Http;

use App\Http\Renderer\ViewRenderer;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;
use PDO;

abstract class AbstractController
{
    /**
     * @var ViewRenderer
     */
    protected ViewRenderer $viewRenderer;

    /**
     * AbstractController constructor.
     * @param PDO $connection
     */
    #[Pure]
    public function __construct(
        protected PDO $connection
    ) {
        $this->viewRenderer = new ViewRenderer;
    }

    /**
     * @param string $controller
     * @param string $action
     * @param array $queryParams
     * @throws Exception
     */
    #[NoReturn]
    protected function redirect(
        string $controller,
        string $action,
        array $queryParams = []
    ) {
        $path = sprintf('/%s/%s', $controller, $action);

        if (!empty($queryParams)) {
            $path .= '?';
            $lastQueryParam = array_key_last($queryParams);

            foreach ($queryParams as $queryParam => $value) {
                $path .= sprintf('%s=%s', $queryParam, $value);

                if ($lastQueryParam !== $queryParam) {
                    $path .= '&';
                }
            }
        }

        $response = new Response;
        $response->getHeaderBag()->offsetSet(
            'Location',
            new Header('Location', $path)
        );
        $response->setStatusCode(302);
        $response->sendHeaders();
        exit;
    }
}