<?php

namespace App\View;

class PartialView implements ViewInterface
{
    /**
     * PartialView constructor.
     * @param string $viewFile
     * @param array $variables
     */
    public function __construct(
        protected string $viewFile,
        protected array $variables = []
    ) {}

    /**
     * @return string
     */
    public function render(): string
    {
        extract($this->variables);

        ob_start();
        include $this->viewFile;
        return ob_get_clean();
    }
}