<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';



    public function selectByUsername($username)
    {
        $username = '%' . $username . '%';
        $query = "SELECT * FROM " . self::TABLE . " WHERE username like :username";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('username', $username, \PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetch();
    }

    public function selectOneByUsername(string $login)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE username=:login");
        $statement->bindValue('login', $login, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
