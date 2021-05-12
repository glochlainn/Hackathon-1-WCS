<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use Amp\Success;
use App\Model\MessageManager;
use App\Model\UserManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $messageManager = new MessageManager();
        $messages = $messageManager->selectAllMessageUsers('post_date', 'DESC');
        $marser = $this->marser();


        return $this->twig->render('Home/index.html.twig', [
            'messages' => $messages,
            'success' => $marser['success'],
            'data' => $marser['data'],
            'errors' => $marser['errors']
        ]);
    }

    public function show()
    {
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = array_map('trim', $_POST);
        }

        if (!empty($name)) {
            $userManager = new UserManager();
            $user = $userManager->selectByUsername($name['username']);

            $messageManager = new MessageManager();
            $userMessages = $messageManager->selectByUserId($user['id']);
        } else {
            $error = "The user don't exist";
            $userMessages = null;
            $user = null;
        }

        return $this->twig->render('Home/show.html.twig', [
            'userMessages' => $userMessages,
            'user' => $user,
            'error' => $error
        ]);
    }
    private const TEXTLENGTH = 280;
    public function marser()
    {
        $message = '';
        $data = [];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);

            if (empty($data['message'])) {
                $errors[] = 'Un message est obligatoire';
            }
            $errors = array_merge($errors, $this->validate($data));
            if (empty($errors)) {
                $message = 'Votre message a bien été envoyé';
                $data = null;
            }
        }

        $marser = [
            'success' => $message,
            'data' => $data,
            'errors' => $errors,
        ];
        return $marser;
    }
    private function validate(array $data): array
    {
        $errors = [];
        if (strlen($data['message']) > self::TEXTLENGTH) {
            $errors[] = 'Le message doit faire moins de ' . self::TEXTLENGTH . ' caractères';
        }
        return $errors;
    }
}
