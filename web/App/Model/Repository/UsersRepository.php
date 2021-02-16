<?php

namespace App\Model\Repository;

use App\Model\Base\AbstractRepository;
use App\Model\DTO\Users;

class UsersRepository extends AbstractRepository
{
    public function find($primaryKey)
    {
        $pdo = $this->connection->getPdo();

        $stmt = $pdo->prepare(<<<SQL
            select * from users where id = :user_id
SQL);

        return $stmt->fetchObject(Users::class, [':user_id' => $primaryKey]);
    }
}