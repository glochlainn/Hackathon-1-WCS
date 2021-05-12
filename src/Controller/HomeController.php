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
use App\Model\UserMessageManager;

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

        return $this->twig->render('Home/show.html.twig', ['userMessages' => $userMessages,
                                                            'user' => $user,
                                                            'error' => $error]);
    }

    public function add(int $id)
    {
        $messageManager = new MessageManager();
        $message = $messageManager->selectOneById($id);

        $userMessageManager = new UserMessageManager();
        $userlike = $userMessageManager->selectOne($id, $_SESSION['user_id']);

        if ($userlike['user_like'] == 1) {
            $message["likescounter"] -= 1;
            $messageManager->updateLikescounter($id, $message["likescounter"]);
            $userMessageManager = new UserMessageManager();
            $userlike = $userMessageManager->updateUserlike($id, $message['user_id'], false);
        } elseif ($userlike['user_like'] == 0) {
            $message["likescounter"] += 1;
            $messageManager->updateLikescounter($id, $message["likescounter"]);
            $userMessageManager = new UserMessageManager();
            $userlike = $userMessageManager->updateUserlike($id, $message['user_id'], true);
        }
        header("Location: /Home/index");
    }
}
