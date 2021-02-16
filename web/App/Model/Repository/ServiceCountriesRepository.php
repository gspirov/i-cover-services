<?php

namespace App\Model\Repository;

use App\Model\Base\AbstractRepository;
use App\Model\DTO\Applications;
use App\Model\DTO\ServiceCountries;
use App\Model\DTO\Services;
use PDO;

class ServiceCountriesRepository extends AbstractRepository
{
    public function find($primaryKey)
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from service_countries where id = :id;
SQL
        );

        $stmt->bindParam('id', $primaryKey, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject(ServiceCountries::class);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from service_countries;
SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, ServiceCountries::class, $this->queryableColumns());
    }

    /**
     * @return string[]
     */
    protected function queryableColumns(): array
    {
        return ['id', 'service_id', 'country_id'];
    }

    /**
     * @param Services $service
     * @return array
     */
    public function findAllByService(Services $service): array
    {
        $sql = <<<SQL
            select * from service_countries where service_id = :service_id;
SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':service_id' => $service->getId()]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, ServiceCountries::class, $this->queryableColumns());
    }

    /**
     * @param Services $service
     * @return bool
     */
    public function deleteAllCountriesByService(Services $service): bool
    {
        $sql = <<<SQL
            delete from service_countries where service_id = :service_id;
SQL;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':service_id' => $service->getId()]);
    }

    /**
     * @param Services $service
     * @param array $countryIds
     * @return bool
     */
    public function linkServiceToCountries(Services $service, array $countryIds): bool
    {
        $values = implode(
            ', ',
            array_map(function () use ($service) {
                return sprintf('(?, %s)', $service->getId());
            }, $countryIds)
        );

        $sql = <<<SQL
            insert into service_countries (country_id, service_id) values $values;
SQL;

        $stmt = $this->pdo->prepare($sql);

        for ($i = 1; $i <= count($countryIds); $i++) {
            $stmt->bindParam($i, $countryIds[$i - 1], PDO::PARAM_INT);
        }

        return $stmt->execute();
    }
}