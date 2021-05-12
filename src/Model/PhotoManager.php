<?php

namespace App\Model;

class PhotoManager extends AbstractManager
{
    public const TABLE = 'photo';


    public function insert($image, $UserId): int
    {
        $query = "INSERT INTO " . self::TABLE . " (`name`, `user_id`)
                VALUES (:name, :user_id)";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('name', $image, \PDO::PARAM_STR);
        $statement->bindValue('user_id', $UserId, \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
