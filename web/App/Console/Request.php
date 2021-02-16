<?php

namespace App\Console;

use App\Base\Request as BaseRequest;

class Request extends BaseRequest
{
    public function handle()
    {
        /**
         * handle console controller/action invocation...
         */
    }

    public function getRequestPath(): string
    {
        /**
         * obtaining console controller/action path
         */

        return '';
    }
}