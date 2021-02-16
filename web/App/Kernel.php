<?php

namespace App;

use App\Base\Request as BaseRequest;
use App\Database\Factory;

class Kernel
{
    /**
     * Kernel constructor.
     * @param BaseRequest $request
     */
    public function __construct(
        private BaseRequest $request
    ) {}

    public function boot()
    {
        $this->initDatabase();
        $this->request->handle();
    }

    private function initDatabase()
    {
        Factory::create(
            'mysql',
            $_ENV['MYSQL_DATABASE'],
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD']
        );
    }
}