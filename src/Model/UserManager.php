<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function selectOneByUsername(string $login)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE username=:login");
        $statement->bindValue('login', $login, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
