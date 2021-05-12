<?php

namespace App\Model;

class MessageManager extends AbstractManager
{
    public const TABLE = 'message';

    public function selectAllMessageUsers(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = "SELECT * FROM " . self::TABLE . " LEFT JOIN user ON "
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
}
