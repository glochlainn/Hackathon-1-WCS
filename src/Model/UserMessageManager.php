<?php

namespace App\Model;

class UserMessageManager extends AbstractManager
{
    public const TABLE = 'user_message';

    public function insert($idMessage, $idUser, $like)
    {
        $query = "INSERT INTO " . self::TABLE . " (`user_id`, `message_id`, `user_like`)
                VALUES (:user_id, :message_id, :user_like)";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('message_id', $idMessage, \PDO::PARAM_INT);
        $statement->bindValue('user_id', $idUser, \PDO::PARAM_INT);
        $statement->bindValue('user_like', $like, \PDO::PARAM_BOOL);

        $statement->execute();
    }



    public function selectOne(int $idMessage, int $idUser)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE message_id=:idMessage AND user_id=:idUser");
        $statement->bindValue('idMessage', $idMessage, \PDO::PARAM_INT);
        $statement->bindValue('idUser', $idUser, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function updateUserlike($idMessage, $idUser, $like)
    {
        $query = "UPDATE " . self::TABLE . " SET user_like = :like WHERE message_id=:idMessage AND user_id=:idUser";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('idMessage', $idMessage, \PDO::PARAM_INT);
        $statement->bindValue('idUser', $idUser, \PDO::PARAM_INT);
        $statement->bindValue('like', $like, \PDO::PARAM_BOOL);

        $statement->execute();
    }
}
