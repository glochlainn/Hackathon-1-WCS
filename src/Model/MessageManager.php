<?php

namespace App\Model;

class MessageManager extends AbstractManager
{
    public const TABLE = 'message';



    public function insert(array $message)
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO " . self::TABLE . " (`content`, `post_date`, `user_id`, `photo_id`)
                VALUES (:content, :post_date, :user_id, :photo_id)";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('content', $message['content'], \PDO::PARAM_STR);
        $statement->bindValue('post_date', $date, \PDO::PARAM_STR);
        $statement->bindValue('user_id', $message['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('photo_id', $message['photo_id'], \PDO::PARAM_INT);

        $statement->execute();
    }
  
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
