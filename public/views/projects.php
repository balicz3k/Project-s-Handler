<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login');
    exit;
}
?>
<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/styles/general-styles.css">
    <link rel="stylesheet" type="text/css" href="/public/styles/projects-styles.css">
    <script src="https://kit.fontawesome.com/723297a893.js" crossorigin="anonymous"></script>
    <title>Projects</title>
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
                <form>
                    <input placeholder="Search projects">
                </form>
            </div>
            <button class="add-project" onclick="window.location.href='/addProject'">
                Add project
            </button>
        </header>
        <section class="projects">
            <?php if (isset($projects) && is_array($projects)): ?>
                <?php foreach($projects as $project): ?>
                    <div id="project-<?= htmlspecialchars($project->getTitle()); ?>" onclick="window.location.href='/scrumBoard?project_id=<?= htmlspecialchars($project->getId()); ?>'">
                    <img src="public/uploads/<?= $project->getImage(); ?>">
                        <div>
                            <h2><?= $project->getTitle(); ?></h2>
                            <p><?= $project->getDescription(); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No projects found.</p>
            <?php endif; ?>
        </section>
    </main>
</div>
</body>