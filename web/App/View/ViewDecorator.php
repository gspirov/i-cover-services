<?php

namespace App\View;

abstract class ViewDecorator implements ViewInterface
{
    /**
     * Layout constructor.
     * @param string $layoutFile
     * @param ViewInterface $partialView
     */
    public function __construct(
        protected string $layoutFile,
        protected ViewInterface $partialView
    ) {}
}