<?php

namespace App\Model;

class MessageManager extends AbstractManager
{
    public const TABLE = 'message';

    public function insert(array $message, $photoId = null)
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO " . self::TABLE . " (`content`, `post_date`, `user_id`, `photo_id`)
                VALUES (:content, :post_date, :user_id, :photo_id)";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('content', $message['content'], \PDO::PARAM_STR);
        $statement->bindValue('post_date', $date, \PDO::PARAM_STR);
        $statement->bindValue('user_id', $message['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('photo_id', $photoId, \PDO::PARAM_INT);

        $statement->execute();
    }

    public function selectAllMessageUsers(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = "SELECT *, message.id as id_message FROM " . self::TABLE . " LEFT JOIN user ON "
            . self::TABLE . ".user_id=user.id LEFT JOIN photo ON " . self::TABLE . ".photo_id=photo.id";
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        $statement = $this->pdo->prepare($query);

        $statement->execute();
        return $statement->fetchAll();
    }

    public function updatePhoto(int $photoId, int $idMessage): void
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET photo_id=:photo_id WHERE id= " . $idMessage);
        $statement->bindValue('photo_id', $photoId, \PDO::PARAM_INT);

        $statement->execute();
    }

    public function selectByUserId(int $idUser)
    {
        $query = "SELECT * FROM " . self::TABLE . " LEFT JOIN user ON "
            . self::TABLE . ".user_id=user.id LEFT JOIN photo ON "
            . self::TABLE . ".photo_id=photo.id WHERE " . self::TABLE . ".user_id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $idUser, \PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll();
    }

    public function updateLikescounter(int $idMessage, int $likescounter)
    {
        $query = "UPDATE " . self::TABLE . " SET likescounter = :likescounter WHERE id=:idMessage";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('idMessage', $idMessage, \PDO::PARAM_INT);
        $statement->bindValue('likescounter', $likescounter, \PDO::PARAM_INT);

        $statement->execute();
    }
}
