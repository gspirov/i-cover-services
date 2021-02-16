<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    /**
     * @var PDO[] $_instances
     */
    private static array $_instances;

    /**
     * Connection constructor.
     * @param PDO $pdo
     * @param string $databaseName
     */
    public function __construct(
        private PDO $pdo,
        private string $databaseName
    ) {
        if (self::hasInstance($this->databaseName)) {
            throw new PDOException(sprintf('A connection instance to %s already exists.', $this->databaseName));
        }

        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$_instances[$this->databaseName] = $this->pdo;
    }

    /**
     * @param string $databaseName
     * @return PDO
     */
    public static function getInstance(string $databaseName): PDO
    {
        if (!self::hasInstance($databaseName)) {
            throw new PDOException(sprintf('%s is not in the haystack of instances.', $databaseName));
        }

        return self::$_instances[$databaseName];
    }

    /**
     * @param string $databaseName
     * @return bool
     */
    public static function hasInstance(string $databaseName): bool
    {
        return !empty(self::$_instances[$databaseName]) && self::$_instances[$databaseName] instanceof PDO;
    }

    /**
     * @param array $changeSet
     * @return string
     */
    public static function prepareEntityChangeSet(array $changeSet): string
    {
        $assignmentClause = [];

        foreach (array_keys($changeSet) as $updatableColumn) {
            $assignmentClause[] = sprintf('%s = :%s', $updatableColumn, $updatableColumn);
        }

        return implode(', ', $assignmentClause);
    }

    /**
     * @param array $changeSet
     * @return array
     */
    public static function bindEntityChangeSet(array $changeSet): array
    {
        $params = [];

        foreach ($changeSet as $column => $value) {
            $params[":$column"] = $value;
        }

        return $params;
    }
}