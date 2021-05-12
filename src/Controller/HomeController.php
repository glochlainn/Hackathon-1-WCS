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
use App\Model\CertifiedManager;
use App\Model\UserMessageManager;
use App\Model\PhotoManager;

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

    private const TEXTLENGTH = 280;

    public function index()
    {
        /*$requester = new CertifiedManager();
        $apod = $requester->apod();
        $spacex = $requester->spacex();*/

        $messageManager = new MessageManager();
        $messages = $messageManager->selectAllMessageUsers('post_date', 'DESC');
        $marser = $this->marser();

        
        return $this->twig->render('Home/index.html.twig', [
            /*'apod' => $apod,
            'spacex' => $spacex,*/
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

    public function marser()
    {
        $message = '';
        $data = [];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);


            if (empty($data['content'])) {
                $errors[] = 'Un message est obligatoire';
            }
            $errors = array_merge($errors, $this->validate($data));

            if (!empty($_SESSION)) {
                $data['user_id'] = $_SESSION['id'];
            }

            $fileNameNew = '';
            if (!empty($_FILES['files']['name'][0])) {
                $files = $_FILES['files'];

                $uploaded = array();
                $failed = array();
                $allowed = array('jpg', 'png', 'webp', 'gif');

                foreach ($files['name'] as $position => $fileName) {
                    $fileTemp = $files['tmp_name'][$position];
                    $fileSize = $files['size'][$position];
                    $fileError = $files['error'][$position];
                    $fileExt = explode('.', $fileName);
                    $fileExt = strtolower(end($fileExt));
                    if (in_array($fileExt, $allowed)) {
                        if ($fileError === 0) {
                            if ($fileSize <= 1000000) {
                                $fileNameNew = uniqid('', true) . '.' . $fileExt;
                                $fileDestination = 'uploads/' . $fileNameNew;

                                if (move_uploaded_file($fileTemp, $fileDestination)) {
                                    $uploaded[$position] = $fileDestination;
                                } else {
                                    $failed[$position] = "[{$fileName}] failed to upload.";
                                }
                            } else {
                                $failed[$position] = "[{$fileName}] is too large.";
                            }
                        } else {
                            $failed[$position] = "[{$fileName}] errored with code {$fileError}.";
                        }
                    } else {
                        $failed[$position] = "[{$fileName}] file extension '{$fileExt}' is not allowed.";
                    }
                }
                if (!empty($failed)) {
                    print_r($failed);
                }
            }
            $idPhoto = "";
            if (empty($errors)) {
                if (!empty($fileNameNew && !empty($_SESSION['id']))) {
                    $photoManager = new PhotoManager();
                    $idPhoto = $photoManager->insert($fileNameNew, $_SESSION['id']);
                }

                $messageManager = new MessageManager();
                $userMessages = $messageManager->insert($data, $idPhoto);

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
        if (strlen($data['content']) > self::TEXTLENGTH) {
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
