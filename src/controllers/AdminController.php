<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/ProjectRepository.php';

class AdminController extends AppController
{
    private $userRepository;
    private $projectRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->projectRepository = new ProjectRepository();
    }

    public function admin()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $users = $this->userRepository->getAllUsersWithProjectCount();
        $this->render('admin', ['users' => $users]);
    }

    public function updateRole()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $userId = $_POST['user_id'];
        $role = $_POST['role'];

        $this->userRepository->updateUserRole($userId, $role);
        header('Location: /admin');
    }

    public function deleteUser()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $userId = $_POST['user_id'];
        $this->userRepository->deleteUser($userId);
        header('Location: /admin');
    }
}