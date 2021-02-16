<?php

namespace App\Http\Renderer;

use App\Http\Header;
use App\Http\Response;
use App\View\Layout;
use App\View\PartialView;
use Exception;

class ViewRenderer
{
    /**
     * ViewRenderer constructor.
     * @param string $layoutScriptPath
     * @param string $viewScriptPath
     */
    public function __construct(
        private string $layoutScriptPath = 'View/Templates/Layout',
        private string $viewScriptPath = 'View/Templates'
    ) {}

    /**
     * @param string $viewFile
     * @param array $variables
     * @param string $layoutFile
     * @return Response
     * @throws Exception
     */
    public function render(
        string $viewFile,
        array $variables = [],
        string $layoutFile = 'default'
    ): Response {
        $partialView = new PartialView(
            sprintf('%s/%s/%s.php', APP_PATH . '/App/', $this->viewScriptPath, $viewFile),
            $variables
        );

        $layout = new Layout(
            sprintf('%s/%s/%s.php', APP_PATH . '/App/', $this->layoutScriptPath, $layoutFile),
            $partialView
        );

        $response = new Response;
        $response->getHeaderBag()->offsetSet(
            'Content-Type',
            new Header('Content-Type', 'text/html')
        );

        $response->setContent($layout->render());

        return $response;
    }

    /**
     * @param string $viewFile
     * @param array $variables
     * @return Response
     * @throws Exception
     */
    public function partial(string $viewFile, array $variables = []): Response
    {
        $view = new PartialView(
            sprintf('%s/%s/%s.php', APP_PATH . '/App/', $this->viewScriptPath, $viewFile),
            $variables
        );

        $response = new Response;
        $response->getHeaderBag()->offsetSet(
            'Content-Type',
            new Header('Content-Type', 'text/html')
        );

        $response->setContent($view->render());

        return $response;
    }
}