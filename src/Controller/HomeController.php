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
        $marser = $this->marser();

        return $this->twig->render('Home/index.html.twig', [
            'messages' => $messages,
            'success' => $marser['success'],
            'data' => $marser['data'],
            'errors' => $marser['errors'],
            'SESSION' => $_SESSION
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
            'error' => $error,
            'SESSION' => $_SESSION
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

    public function add(int $id)
    {
        $messageManager = new MessageManager();
        $message = $messageManager->selectOneById($id);

        if (!empty($_SESSION)) {
            $userMessageManager = new UserMessageManager();
            $userlike = $userMessageManager->selectOne($id, $_SESSION['id']);

            if (empty($userlike)) {
                $userMessageManager = new UserMessageManager();
                $userlike = $userMessageManager->insert($id, $_SESSION['id'], true);
                $message["likescounter"] += 1;
                $messageManager->updateLikescounter($id, $message["likescounter"]);
            } else {
                if ($userlike['user_like'] == 1) {
                    $message["likescounter"] -= 1;
                    $messageManager->updateLikescounter($id, $message["likescounter"]);
                    $userMessageManager = new UserMessageManager();
                    $userlike = $userMessageManager->updateUserlike($id, $_SESSION['id'], false);
                } elseif ($userlike['user_like'] == 0) {
                    $message["likescounter"] += 1;
                    $messageManager->updateLikescounter($id, $message["likescounter"]);
                    $userMessageManager = new UserMessageManager();
                    $userlike = $userMessageManager->updateUserlike($id, $_SESSION['id'], true);
                }
            }
        }
        header("Location: /Home/index");
    }
}
