<?php

use App\Controller\DefaultController;
use App\Routing\Route;

return [
    '/' => new Route(DefaultController::class, 'index')
];