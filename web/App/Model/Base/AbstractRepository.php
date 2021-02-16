<?php

namespace App\Model\Base;

use PDO;

abstract class AbstractRepository
{
    /**
     * AbstractRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(
        protected PDO $pdo
    ) {}

    abstract public function find($primaryKey);

    /**
     * @return array
     */
    abstract public function findAll(): array;

    /**
     * @return array
     */
    abstract protected function queryableColumns(): array;
}