<?php

namespace App\Model\Repository;

use App\Database\Connection;
use App\Model\Base\AbstractRepository;
use App\Model\DTO\Applications;
use Exception;
use PDO;

class ApplicationsRepository extends AbstractRepository
{
    public function find($primaryKey)
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from applications where id = :application_id;
SQL
        );

        $stmt->bindParam('application_id', $primaryKey, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject(Applications::class);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare(
            <<<SQL
                select * from applications;
SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Applications::class, $this->queryableColumns());
    }

    /**
     * @return string[]
     */
    protected function queryableColumns(): array
    {
        return ['id', 'first_name', 'last_name', 'dob', 'gender', 'title', 'status', 'created_at'];
    }

    /**
     * @param Applications $application
     * @return bool
     */
    public function create(Applications $application): bool
    {
        $sql = <<<SQL
            insert into applications (first_name, last_name, dob, gender, title) 
            values (:first_name, :last_name, :dob, :gender, :title);
SQL;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':first_name' => $application->getFirstName(),
            ':last_name' => $application->getLastName(),
            ':dob' => $application->getDateOfBirth()->format('Y-m-d'),
            ':gender' => $application->getGender(),
            ':title' => $application->getTitle()
        ]);
    }

    /**
     * @param Applications $application
     * @param array $changeSet
     * @return bool
     * @throws Exception
     */
    public function update(Applications $application, array $changeSet): bool
    {
        if (empty($changeSet)) {
            return true;
        }

        if (empty($application->getId())) {
            throw new Exception('Application has not been saved yet in order to be updated.');
        }

        $setClause = Connection::prepareEntityChangeSet($changeSet);

        $sql = <<<SQL
            update applications set {$setClause} where id = :application_id;
SQL;

        $params = Connection::bindEntityChangeSet($changeSet) + [':application_id' => $application->getId()];
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($params);
    }
}