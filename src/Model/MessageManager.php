<?php

namespace App\Model;

class MessageManager extends AbstractManager
{
    public const TABLE = 'message';

    public function selectAllMessageUsers(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = "SELECT * FROM " . self::TABLE . " INNER JOIN user ON "
        . self::TABLE . ".user_id=user.id";
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        $statement = $this->pdo->prepare($query);

        $statement->execute();
        return $statement->fetchAll();
    }
}
