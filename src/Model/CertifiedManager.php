<?php

namespace App\Model;

use App\Model\RequestManager;
use DateTime;

class CertifiedManager extends AbstractManager
{
    public const USER_TABLE = 'user';
    public const PHOTO_TABLE = 'photo';
    public const MESSAGE_TABLE = 'message';

    private function randomDate()
    {
        //Generate a timestamp using mt_rand.
        $timestamp = mt_rand(1, time());

        //Format that timestamp into a readable date string.
        $randomDate = date("Y-m-d H:i:s", $timestamp);

        //Print it out.
        return $randomDate;
    }

    public function apod()
    {
        $username = "APOD";
        $present = 0;
        $messagePresent = 0;
        $apodDate = $this->randomDate();

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

        $title = $statement->fetchAll();
        $titleNumbers = count($title);

        for ($i = 0; $i < $titleNumbers; $i++) {
            if (in_array($apod['title'], $title[$i])) {
                $present = 1;
            }
        }

        if ($present === 0) {
            //insérer l'image en BDD
            $statement = $this->pdo->prepare("INSERT INTO " . self::PHOTO_TABLE . " (`name`, `url`, `user_id`) 
            VALUES (:name, :url, :user_id)");
            $statement->bindValue('name', $apod['title'], \PDO::PARAM_STR);
            $statement->bindValue('url', $apod['url'], \PDO::PARAM_STR);
            $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);

            $statement->execute();
        }

        //récuperer le photo_id
        $statement = $this->pdo->prepare("SELECT id FROM " . static::PHOTO_TABLE . " 
        WHERE user_id=:user_id AND name=:name");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $apod['title'], \PDO::PARAM_STR);
        $statement->execute();

        $photoId = $statement->fetch();
        //Si $apod[title] n'existe pas en table message
        $statement = $this->pdo->prepare("SELECT photo_id FROM " . static::MESSAGE_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
        $statement->execute();

        $photo = $statement->fetchAll();
        $photoNumbers = count($photo);
        for ($i = 0; $i < $photoNumbers; $i++) {
            if ($photoId['id'] === $photo[$i]['photo_id']) {
                $messagePresent = 1;
            }
        }

        if ($messagePresent === 0) {
            //insérer le message en BDD
            $statement = $this->pdo->prepare("INSERT INTO " . self::MESSAGE_TABLE . " (
            `content`, `post_date`, `user_id`, `photo_id`
            ) 
            VALUES (:content, :post_date, :user_id, :photo_id)");
            $statement->bindValue('content', $apod['explanation'], \PDO::PARAM_STR);
            $statement->bindValue('post_date', $apodDate, \PDO::PARAM_STR);
            $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);
            $statement->bindValue('photo_id', $photoId['id'], \PDO::PARAM_STR);

            $statement->execute();
        }
    }

    public function spacex()
    {
        $username = "spacex";
        $spacexPresent = 0;
        $date = new DateTime('now');
        $date = $date->format("Y-m-d H:i:s");
        $requestManager = new RequestManager();
        $spacex = [];
        $spacexDate = $this->randomDate();
        $pathToApi = "https://api.spacexdata.com/v4/rockets";
        $spacex = $requestManager->request($pathToApi);
        $statement = $this->pdo->prepare("SELECT id FROM " . static::USER_TABLE . " WHERE username=:username");
        $statement->bindValue('username', $username, \PDO::PARAM_STR);
        $statement->execute();
        $userId = $statement->fetch();

        $statement = $this->pdo->prepare("SELECT name FROM " . static::PHOTO_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
        $statement->execute();
        $title = $statement->fetchAll();
        $rocketNumbers = count($spacex);
        $titleNumbersSpacex = count($title);

        for ($i = 0; $i < $rocketNumbers; $i++) {
            for ($y = 0; $y < $titleNumbersSpacex; $y++) {
                if ($title[$y]['name'] == $spacex[$i]['name']) {
                    $spacexPresent = 1;
                }
            }
        }

        for ($i = 0; $i < $rocketNumbers; $i++) {
            if ($spacexPresent === 0) {
                $statement = $this->pdo->prepare("INSERT INTO " . self::PHOTO_TABLE . "
                (`name`, `url`, `user_id`)
                VALUES (:name, :url, :user_id)");
                $statement->bindValue('name', $spacex[$i]['name'], \PDO::PARAM_STR);
                $statement->bindValue('url', $spacex[$i]['flickr_images']['0'], \PDO::PARAM_STR);
                $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);

                $statement->execute();
            }
        }

        $statement = $this->pdo->prepare("SELECT id FROM " . static::PHOTO_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_STR);
        $statement->execute();
        $photoId = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $statement = $this->pdo->prepare("SELECT photo_id FROM " . static::MESSAGE_TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
        $statement->execute();
        $photo = $statement->fetchAll();
        $photoNumbers = count($photo);

        for ($i = 0; $i < $rocketNumbers; $i++) {
            if (empty($photo)) {
                $statement = $this->pdo->prepare("SELECT id FROM " . static::PHOTO_TABLE . " 
                WHERE user_id=:user_id AND name=:name");
                $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
                $statement->bindValue('name', $spacex[$i]['name'], \PDO::PARAM_STR);
                $statement->execute();

                $photoIdName = $statement->fetch();
                $statement = $this->pdo->prepare("INSERT INTO " . self::MESSAGE_TABLE . "
                (`content`, `post_date`, `user_id`, `photo_id`)
                VALUES (:content, :post_date, :user_id, :photo_id)");
                $statement->bindValue('content', $spacex[$i]['description'], \PDO::PARAM_STR);
                $statement->bindValue('post_date', $spacexDate, \PDO::PARAM_STR);
                $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
                $statement->bindValue('photo_id', $photoIdName['id'], \PDO::PARAM_INT);

                $statement->execute();
            }

            for ($y = 0; $y < $photoNumbers; $y++) {
                if (!in_array($photo[$y]['photo_id'], $photoId[$i])) {
                    $statement = $this->pdo->prepare("SELECT id FROM " . static::PHOTO_TABLE . "
                    WHERE user_id=:user_id AND name=:name");
                    $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
                    $statement->bindValue('name', $spacex[$i]['name'], \PDO::PARAM_STR);
                    $statement->execute();
                    $photoIdName = $statement->fetch();
                    $statement = $this->pdo->prepare("INSERT INTO " . self::MESSAGE_TABLE . "
                    (`content`, `post_date`, `user_id`, `photo_id`)
                    VALUES (:content, :post_date, :user_id, :photo_id)");
                    $statement->bindValue('content', $spacex[$i]['description'], \PDO::PARAM_STR);
                    $statement->bindValue('post_date', $spacexDate, \PDO::PARAM_STR);
                    $statement->bindValue('user_id', $userId['id'], \PDO::PARAM_INT);
                    $statement->bindValue('photo_id', $photoIdName['id'], \PDO::PARAM_INT);

                    $statement->execute();
                }
            }
        }
    }
}
