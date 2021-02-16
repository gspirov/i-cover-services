<?php

namespace App\View;

class Layout extends ViewDecorator
{
    /**
     * @return string
     */
    public function render(): string
    {
        $content = $this->partialView->render();
        extract(compact('content'));

        ob_start();
        include $this->layoutFile;
        return ob_get_clean();
    }
}