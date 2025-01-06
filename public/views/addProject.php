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
            <li>
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
                <i class="fas fa-plus"></i> add project
            </div>
        </header>
        <section class="project-form">
            <h1>UPLOAD</h1>
            <form action="/addProject" method="POST" ENCTYPE="multipart/form-data">
                <div class="messages">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <input name="title" type="text" placeholder="title">
                <textarea name="description" rows=5 placeholder="description"></textarea>

                <input type="file" name="file"/><br/>
                <button type="submit">send</button>
            </form>
        </section>
    </main>
</div>
</body>