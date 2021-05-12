<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

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

        return $this->twig->render('Home/index.html.twig', ['messages' => $messages]);
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
}
