<?php

use App\Http\Renderer\ViewRenderer;
use App\Model\DTO\Applications;

/**
 * @var Applications $application
 */

$viewRenderer = new ViewRenderer;

echo $viewRenderer->partial('Applications/form', compact('application'))->getContent();