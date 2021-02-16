<?php

namespace App\Model\Repository;

use App\Model\Base\AbstractRepository;
use App\Model\DTO\Countries;
use PDO;

class CountriesRepository extends AbstractRepository
{
    public function find($primaryKey)
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from countries where id = :country_id;
SQL
        );

        $stmt->execute([':country_id' => $primaryKey]);
        return $stmt->fetchObject(Countries::class);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from countries;
SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Countries::class, $this->queryableColumns());
    }

    /**
     * @return string[]
     */
    protected function queryableColumns(): array
    {
        return ['id', 'name', 'iso2'];
    }

    /**
     * @param Countries $country
     * @return bool
     */
    public function create(Countries $country): bool
    {
        $sql = <<<SQL
            insert into countries (name, iso2) 
            values (:name, :iso2);
SQL;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $country->getName(),
            ':iso2' => $country->getIso2()
        ]);
    }
}