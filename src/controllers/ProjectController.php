<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Project.php';
require_once __DIR__.'/../repository/ProjectRepository.php';

class ProjectController extends AppController {

    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $projectRepository;

    public function __construct()
    {
        parent::__construct();
        $this->projectRepository = new ProjectRepository();
    }

    public function projects()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: /login');
            exit;
        }
        $userId = $_SESSION['user_id'];
        $projects = $this->projectRepository->getProjectsByUserId($userId);
        $this->render('projects', ['projects' => $projects]);
    }

    public function addProject()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            throw new Exception('User is not logged in.');
        }

        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            $project = new Project(0,$_POST['title'], $_POST['description'], $_FILES['file']['name']);
            $this->projectRepository->addProject($project);

            header('Location: /projects');
            exit;
        }

        return $this->render('addProject', ['messages' => $this->message]);
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }

    public function updateProjectTitle()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: /login');
            exit;
        }

        if ($this->isPost()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $projectId = $data['project_id'];
            $title = $data['title'];

            $this->projectRepository->updateProjectTitle($projectId, $title);

            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
    }

    public function deleteProject()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: /login');
            exit;
        }

        if ($this->isPost()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $projectId = $data['project_id'];

            $this->projectRepository->deleteProject($projectId);

            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
    }
}
