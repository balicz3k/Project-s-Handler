<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once 'SecurityController.php';

class UserController extends AppController {

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function user()
    {
        $this->render('user');
    }

    public function update()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            throw new Exception('User is not logged in.');
        }
        $userId = $_SESSION['user_id'];

        $email = $_POST['email'] ?? null;
        $nickname = $_POST['nickname'] ?? null;
        $updatedPassword = $_POST['password'] ?? null;

        if ($email)
        {
            if(!SecurityController::isValidEmail($email))
            {
                $this->render('user', ['messages' => ['Invalid email address!']]);
            }
            else
            {
                $this->userRepository->updateEmail($userId, $email);
            }
        }
        elseif ($nickname)
        {
            $this->userRepository->updateNickname($userId, $nickname);
        }
        elseif ($updatedPassword)
        {
            if(!SecurityController::isStrongPassword($updatedPassword))
            {
                $this->render('user', ['messages' => ['Invalid password!']]);
            }
            else
            {
                $password = password_hash($updatedPassword, PASSWORD_DEFAULT);
                $this->userRepository->updatePassword($userId, $password);
            }
        }

        $this->render('user', ['messages' => ['User info updated successfully!']]);
    }
}