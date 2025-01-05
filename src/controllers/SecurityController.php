<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/../repository/UserRepository.php';

class SecurityController extends AppController {

    public function login()
    {
        session_start();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = (new UserRepository())->getUser($email);

        if(!$user) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $_SESSION['loggedin'] = true;
        $_SESSION['user_email'] = $user->getEmail();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/boardView");
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $nickname = $_POST["nickname"] ??"";
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['re-password'] ?? '';

        $userRepository = new UserRepository();

        if ($userRepository->getUser($email)) {
            return $this->render('register', ['messages' => ['User already exists!']]);
        }

        if(!$this->isValidEmail($email)) {
            return $this->render('register', ['messages' => ['Invalid email address!']]);
        }

        if ($password !== $confirmPassword) {
            return $this->render('register', ['messages' => ['Passwords do not match!']]);
        }

        if (!$this->isStrongPassword($password)) {
            return $this->render('register', ['messages' => ['Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character!']]);
        }

        $user = new User($email, password_hash($password, PASSWORD_DEFAULT), $nickname);
        $userRepository->createUser($user);

        session_start();
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['user_email'] = $user->getEmail();

        header("Location: /login");
        exit;
    }

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    private function isStrongPassword(string $password): bool
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', $password);
    }
}