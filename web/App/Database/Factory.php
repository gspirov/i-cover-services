<?php

namespace App\Database;

use PDO;
use Throwable;

abstract class Factory
{
    /**
     * @param string $host
     * @param string $name
     * @param string $username
     * @param string $password
     */
    public static function create(
        string $host,
        string $name,
        string $username,
        string $password
    ) {
        try {
            if (!Connection::hasInstance($name)) {
                $pdo = new PDO(
                    sprintf('mysql:host=%s;dbname=%s;port=3306', $host, $name),
                    $username,
                    $password
                );

                new Connection($pdo, $name);
            }
        } catch (Throwable $exception) {
            // .. exception handling on unsuccessful connecting ..
        }
    }
}