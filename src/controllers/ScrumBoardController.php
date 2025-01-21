<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Task.php';
require_once __DIR__.'/../repository/TaskRepository.php';
class ScrumBoardController extends AppController
{
    private $taskRepository;

    public function __construct()
    {
        parent::__construct();
        $this->taskRepository = new TaskRepository();
    }

    public function scrumBoard()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: /login');
            exit;
        }

        if (isset($_GET['project_id'])) {
            $_SESSION['project_id'] = $_GET['project_id'];
        }

        if (!isset($_SESSION['project_id'])) {
            throw new Exception('Project ID is required.');
        }

        $projectId = $_SESSION['project_id'];
        $tasks = $this->taskRepository->getTasksByProjectId($projectId);
        $this->render('scrumBoard', ['tasks' => $tasks]);
    }

    public function addTask()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            throw new Exception('User is not logged in.');
        }

        if ($this->isPost()) {
            $projectId = $_POST['project_id'];
            $title = $_POST['title'];
            $color = $_POST['color'];

            $this->taskRepository->addTask($projectId, $title, $color);

            header("Location: /scrumBoard");
            exit;
        }

    }

    public function updateTaskStatus()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: /login');
            exit;
        }

        if ($this->isPost()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $taskId = $data['task_id'];
            $status = $data['status'];

            $this->taskRepository->updateTaskStatus($taskId, $status);

            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
    }

    public function updateTaskTitle()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: /login');
            exit;
        }

        if ($this->isPost()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $taskId = $data['task_id'];
            $title = $data['title'];

            $this->taskRepository->updateTaskTitle($taskId, $title);

            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
    }

    public function updateTaskColor()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: /login');
            exit;
        }

        if ($this->isPost()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $taskId = $data['task_id'];
            $color = $data['color'];

            $this->taskRepository->updateTaskColor($taskId, $color);

            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
    }

    public function deleteTask()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: /login');
            exit;
        }

        if ($this->isPost()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $taskId = $data['task_id'];

            $this->taskRepository->deleteTask($taskId);

            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
    }

}