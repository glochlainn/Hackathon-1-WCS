<?php

namespace App\Model;

use App\Model\RequestManager;
use DateTime;

class CertifiedManager extends AbstractManager
{
    public const USER_TABLE = 'user';
    public const PHOTO_TABLE = 'photo';
    public const MESSAGE_TABLE = 'message';


    public function apod(): void
    {
        $username = "APOD";
        $present = 0;
        $messagePresent = 0;
        $date = new DateTime('now');
        $date = $date->format("Y-m-d H:i:s");

        //récupérer les données de l'API
        $requestManager = new RequestManager();
        $apod = [];

        $pathToApi = "https://api.nasa.gov/planetary/apod?api_key=py0aw8fbod4CL9qIJywHUoxTYgVcBoWvsK4v16QN";

        $apod = $requestManager->request($pathToApi);

        //récuperer l'user user_id
        $statement = $this->pdo->prepare("SELECT id FROM " . static::USER_TABLE . " WHERE username=:username");
        $statement->bindValue('username', $username, \PDO::PARAM_STR);
        $statement->execute();

        $userId = $statement->fetch();
        //Si $apod[title] n'existe pas en table photo
        $statement = $this->pdo->prepare("SELECT name FROM " . static::PHOTO_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
        $statement->execute();

        $title = $statement->fetch();

        if ($title != false) {
            $present = in_array($apod['title'], $title);
        }

        if ($present === 0) {
            //insérer l'image en BDD
            $statement = $this->pdo->prepare("INSERT INTO " . self::PHOTO_TABLE . " (`name`, `url`, `user_id`) 
            VALUES (:name, :url, :user_id)");
            $statement->bindValue('name', $apod['title'], \PDO::PARAM_STR);
            $statement->bindValue('url', $apod['url'], \PDO::PARAM_STR);
            $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);

            $statement->execute();
        }

        //récuperer le photo_id
        $statement = $this->pdo->prepare("SELECT id FROM " . static::PHOTO_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);
        $statement->execute();

        $photoId = $statement->fetch();

        //Si $apod[title] n'existe pas en table message
        $statement = $this->pdo->prepare("SELECT photo_id FROM " . static::MESSAGE_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
        $statement->execute();

        $photo = $statement->fetch();

        if ($photo != false) {
            $messagePresent = in_array($photoId['id'], $photo);
        }

        if ($messagePresent === 0) {
            //insérer le message en BDD
            $statement = $this->pdo->prepare("INSERT INTO " . self::MESSAGE_TABLE . " (
            `content`, `post_date`, `user_id`, `photo_id`
            ) 
            VALUES (:content, :post_date, :user_id, :photo_id)");
            $statement->bindValue('content', $apod['explanation'], \PDO::PARAM_STR);
            $statement->bindValue('post_date', $date, \PDO::PARAM_STR);
            $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);
            $statement->bindValue('photo_id', $photoId['id'], \PDO::PARAM_STR);

            $statement->execute();
        }
    }

   /* public function apod(): void
    {
        $username = "APOD";
        $present = 0;
        $messagePresent = 0;
        $date = new DateTime('now');
        $date = $date->format("Y-m-d H:i:s");
        var_dump($date);

        //récupérer les données de l'API
        $requestManager = new RequestManager;
        $apod = [];

        $pathToApi = "https://api.nasa.gov/planetary/apod?api_key=py0aw8fbod4CL9qIJywHUoxTYgVcBoWvsK4v16QN";

        $apod = $requestManager->request($pathToApi);
        var_dump($apod);

        //récuperer l'user user_id
        $statement = $this->pdo->prepare("SELECT id FROM " . static::USER_TABLE . " WHERE username=:username");
        $statement->bindValue('username', $username, \PDO::PARAM_STR);
        $statement->execute();

        $userId = $statement->fetch();
        var_dump($userId);

        //Si $apod[title] n'existe pas en table photo
        $statement = $this->pdo->prepare("SELECT name FROM " . static::PHOTO_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
        $statement->execute();

        $title = $statement->fetch();
        var_dump($title);
        if ($title != false) {
            $present = in_array($apod['title'], $title);
        }
        var_dump($present);
        if ($present === 0) {
            //insérer l'image en BDD
            $statement = $this->pdo->prepare("INSERT INTO " . self::PHOTO_TABLE . "
            (`name`, `url`, `user_id`)
            VALUES (:name, :url, :user_id)");
            $statement->bindValue('name', $apod['title'], \PDO::PARAM_STR);
            $statement->bindValue('url', $apod['url'], \PDO::PARAM_STR);
            $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);

            $statement->execute();
        }

        //récuperer le photo_id
        $statement = $this->pdo->prepare("SELECT id FROM " . static::PHOTO_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);
        $statement->execute();

        $photoId = $statement->fetch();
        var_dump($photoId);

        //Si $apod[title] n'existe pas en table message
        $statement = $this->pdo->prepare("SELECT photo_id FROM " . static::MESSAGE_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
        $statement->execute();

        $photo = $statement->fetch();
        var_dump($photo);
        if ($photo != false) {
            $messagePresent = in_array($photoId['id'], $photo);
        }

        if ($messagePresent === 0) {
            //insérer le message en BDD
            $statement = $this->pdo->prepare("INSERT INTO " . self::MESSAGE_TABLE . "
            (`content`, `post_date`, `user_id`, `photo_id`)
            VALUES (:content, :post_date, :user_id, :photo_id)");
            $statement->bindValue('content', $apod['explanation'], \PDO::PARAM_STR);
            $statement->bindValue('post_date', $date, \PDO::PARAM_STR);
            $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);
            $statement->bindValue('photo_id', $photoId['id'], \PDO::PARAM_STR);

            $statement->execute();
        }
        var_dump($messagePresent);
    } */
}
