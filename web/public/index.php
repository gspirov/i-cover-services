<?php

use App\Http\Handler\EntryPoint;
use App\Http\Handler\ErrorHandler;
use App\Http\Handler\ExceptionHandler;
use App\Http\Request;
use App\Kernel;

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_PATH', dirname($_SERVER['DOCUMENT_ROOT']));

$errorHandlerEntryPoint = new EntryPoint(
    new ExceptionHandler,
    new ErrorHandler
);

$errorHandlerEntryPoint->register();

$request = new Request;
$kernel = new Kernel($request);
$kernel->boot();