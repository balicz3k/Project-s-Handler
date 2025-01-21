<?php

require_once __DIR__.'/../models/Task.php';

class TaskRepository {

    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getTasksByProjectId($projectId)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tasks WHERE project_id = :project_id
        ');
        $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [
            'not_started' => [],
            'in_progress' => [],
            'done' => []
        ];

        foreach ($tasks as $task) {
            $result[$task['status']][] = $task;
        }

        return $result;
    }

    public function addTask($projectId, $title, $color)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tasks (project_id, title, color) VALUES (:project_id, :title, :color)
        ');
        $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function updateTaskStatus($taskId, $status)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE tasks SET status = :status WHERE id = :task_id
        ');
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateTaskTitle($taskId, $title)
    {
        $stmt = $this->database->connect()->prepare('UPDATE tasks SET title = :title WHERE id = :id');
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateTaskColor($taskId, $color)
    {
        $stmt = $this->database->connect()->prepare('UPDATE tasks SET color = :color WHERE id = :id');
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteTask($taskId)
    {
        $stmt = $this->database->connect()->prepare('DELETE FROM tasks WHERE id = :id');
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
    }
}

