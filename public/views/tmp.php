<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrum Board</title>
    <link rel="stylesheet" href="/public/styles/general-styles.css">
    <link rel="stylesheet" href="/public/styles/scrum-board-styles.css">
    <script src="/public/javascript/dragAndDrop.js" defer></script>
</head>
<body>
<div class="scrum-board-container">
    <header>
        <form action="/addTask" method="POST">
            <input type="hidden" name="project_id" value="<?= $_GET['project_id']; ?>">
            <input type="text" name="title" placeholder="Task Title" required>
            <input type="color" name="color" required>
            <button type="submit">Add Task</button>
        </form>
    </header>
    <div class="scrum-board">
        <div class="column" id="not-started">
            <h2>Not Started</h2>
            <?php foreach ($tasks['not_started'] as $task): ?>
                <div class="task" id="task-<?= $task['id']; ?>" draggable="true" style="background-color: <?= $task['color']; ?>;">
                    <?= $task['title']; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="column" id="in-progress">
            <h2>In Progress</h2>
            <?php foreach ($tasks['in_progress'] as $task): ?>
                <div class="task" id="task-<?= $task['id']; ?>" draggable="true" style="background-color: <?= $task['color']; ?>;">
                    <?= $task['title']; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="column" id="done">
            <h2>Done</h2>
            <?php foreach ($tasks['done'] as $task): ?>
                <div class="task" id="task-<?= $task['id']; ?>" draggable="true" style="background-color: <?= $task['color']; ?>;">
                    <?= $task['title']; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>