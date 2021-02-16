<?php

namespace App\Model\Repository;

use App\Model\Base\AbstractRepository;
use App\Model\DTO\Services;
use PDO;

class ServicesRepository extends AbstractRepository
{
    public function find($primaryKey)
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from services where id = :service_id;
SQL
        );

        $stmt->execute([':service_id' => $primaryKey]);
        return $stmt->fetchObject(Services::class);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from services;
SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Services::class, $this->queryableColumns());
    }

    /**
     * @return string[]
     */
    protected function queryableColumns(): array
    {
        return ['id', 'name', 'description', 'available', 'created_at', 'updated_at'];
    }

    /**
     * @param Services $service
     * @return bool
     */
    public function create(Services $service): bool
    {
        $sql = <<<SQL
            insert into services (name, description, available)
            values (:name, :description, :available);
SQL;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $service->getName(),
            ':description' => $service->getDescription(),
            ':available' => (int) $service->isAvailable()
        ]);
    }
}