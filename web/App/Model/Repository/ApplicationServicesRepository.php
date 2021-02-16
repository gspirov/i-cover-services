<?php

namespace App\Model\Repository;

use App\Model\Base\AbstractRepository;
use App\Model\DTO\Applications;
use App\Model\DTO\ApplicationServices;
use App\Model\DTO\ApplicationServicesResultRow;
use App\Model\DTO\ServiceCountryResultRow;
use PDO;

class ApplicationServicesRepository extends AbstractRepository
{
    public function find($primaryKey)
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from application_services where id = :id;
SQL
        );

        $stmt->bindParam('id', $primaryKey, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject(ApplicationServices::class);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from application_services;
SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, ApplicationServices::class, $this->queryableColumns());
    }

    /**
     * @return string[]
     */
    protected function queryableColumns(): array
    {
        return ['id', 'application_id', 'country_service_id', 'requested_by'];
    }

    /**
     * @param Applications $application
     * @return array
     */
    public function findAllByApplication(Applications $application): array
    {
        $sql = <<<SQL
            select concat_ws(' ', applications.first_name, applications.last_name) as applicant, 
                   services.name as service,
                   countries.name as country,
                   concat_ws(' ', users.first_name, users.last_name) as requestedUser
            from application_services
            join applications on application_services.application_id = applications.id
            join service_countries on application_services.country_service_id = service_countries.id
            join countries on service_countries.country_id = countries.id
            join services on service_countries.service_id = services.id
            join users on application_services.requested_by = users.id
            where application_id = :application_id;
SQL;

        $applicationId = $application->getId();

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':application_id', $applicationId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(
            PDO::FETCH_CLASS,
            ApplicationServicesResultRow::class,
            ['applicant', 'country', 'service', 'requestedUser']
        );
    }

    /**
     * @param Applications $application
     * @return array
     */
    public function fetchAvailableApplicationCountryServices(Applications $application): array
    {
        $sql = <<<SQL
            select service_countries.id as serviceCountryId,
                   services.name as service
            from services
            join service_countries on services.id = service_countries.service_id
            where services.id not in (
                select service_countries.service_id
                from service_countries
                join application_services on service_countries.id = application_services.country_service_id
                where application_services.application_id = :application_id
            );
SQL;

        $applicationId = $application->getId();

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':application_id' => $applicationId]);

        return $stmt->fetchAll(
            PDO::FETCH_CLASS,
            ServiceCountryResultRow::class,
            ['serviceCountryId', 'service']
        );
    }

    public function addApplicationCountryServices(Applications $application, array $countryServiceIds)
    {
        $values = implode(
            ', ',
            array_map(function ($countryServiceId) use ($application) {
                return sprintf('(?, %s)', $application->getId());
            }, $countryServiceIds)
        );

        $sql = <<<SQL
            insert into application_services (application_id, country_service_id, requested_by) 
            values ()
SQL;


//        $stmt = $this->pdo->prepare()
    }
}