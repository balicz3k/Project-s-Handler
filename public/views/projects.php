<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login');
    exit;
}
?>
<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/styles/other-view-styles.css">
    <script src="https://kit.fontawesome.com/723297a893.js" crossorigin="anonymous"></script>
    <title>PROJECTS</title>
</head>

<body>
<div class="base-container">
    <nav>
        <img src="/public/assets/ProjectsHandler-logo.png">
        <ul>
            <li>
                <i class="fas fa-project-diagram"></i>
                <a href="/projects" class="button">Projects</a>
            </li>
            <li onclick="window.location.href='/user'">
                <i class="fas fa-project-diagram"></i>
                <a href="#" class="button">User</a>
            </li>
            <li>
                <i class="fas fa-project-diagram"></i>
                <a href="#" class="button">Admin</a>
            </li>
            <li>
                <i class="fas fa-project-diagram"></i>
                <a href="/logout" class="button">Logout</a>
            </li>
        </ul>
    </nav>
    <main>
        <header>
            <div class="search-bar">
                <form>
                    <input placeholder="search project">
                </form>
            </div>
            <div class="add-project" onclick="window.location.href='/addProject'">
                <i class="fas fa-plus"></i> Add project
            </div>
        </header>
        <section class="projects">
            <?php if (isset($projects) && is_array($projects)): ?>
            <?php foreach($projects as $project): ?>
                <div id="project-1">
                    <img src="public/uploads/<?= $project->getImage(); ?>">
                    <div>
                        <h2><?= $project->getTitle(); ?></h2>
                        <p><?= $project->getDescription(); ?></p>
                        <div class="social-section">
                            <i class="fas fa-heart"> 600</i>
                            <i class="fas fa-minus-square"> 121</i>
                        </div>
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