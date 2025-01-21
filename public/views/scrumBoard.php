<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login');
    exit;
}
?>
<!DOCTYPE html>

<head>
    <title>Scrum Board</title>
    <link rel="stylesheet" href="/public/styles/general-styles.css">
    <link rel="stylesheet" href="/public/styles/scrum-board-styles.css">
    <script src="/public/javascript/drag-and-drop.js" defer></script>
    <script src="/public/javascript/context-menu.js" defer></script>
    <script src="/public/javascript/color-input-change.js" defer></script>
</head>
<body>
<div class="base-container">
    <nav>
        <img src="/public/assets/ProjectsHandler-logo.png">
        <ul>
            <li><a href="/projects" class="button">Projects</a></li>
            <li><a href="/user" class="button">User</a></li>
            <?php if ($_SESSION['user_role'] === 'admin'):?>
                <li><a href="/admin" class="button">Admin</a></li>
            <?php endif; ?>
            <li><a href="/logout" class="button">Logout</a></li>
        </ul>
    </nav>
    <main>
        <header>
            <div class="search-bar">
                <form class="task-form" id="addTaskForm" action="/addTask" method="POST">
                    <input type="hidden" name="project_id" value="<?= $_GET['project_id']; ?>">
                    <input placeholder="Task title" name="title" required>
                    <input id="colorInput" type="color" name="color" required>
                </form>
            </div>
            <button class="add-project" type="submit" form="addTaskForm" ">
                Add project
            </button>
        </header>
        <section class="scrum-board">
            <div class="column" id="not_started">
                <h2>Not Started</h2>
                <?php foreach ($tasks['not_started'] as $task): ?>
                    <div class="task" id="task-<?= $task['id']; ?>" draggable="true" style="background-color: <?= $task['color']; ?>;">
                        <?= $task['title']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="column" id="in_progress">
                <h2>In Progress</h2>
                <?php foreach ($tasks['in_progress'] as $task): ?>
                    <div class="task" id="task-<?= $task['id']; ?>" draggable="true" style="background-color: <?= $task['color']; ?>;" >
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
        </section>
    </main>
</div>

<!-- Context Menu -->
<div class="context-menu" id="contextMenu">
    <button id="editTitle">Edit Title</button>
    <button id="editColor">Edit Color</button>
    <button id="deleteTask">Delete Task</button>
</div>
</body>