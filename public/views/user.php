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
    <title>User Profile</title>
    <link rel="stylesheet" href="/public/styles/other-view-styles.css">
</head>
<body>
<div class="base-container">
    <nav>
        <img src="/public/assets/ProjectsHandler-logo.png">
        <ul>
            <li><a href="/projects" class="button">Projects</a></li>
            <li><a href="/user" class="button">User</a></li>
            <li><a href="/logout" class="button">Logout</a></li>
        </ul>
    </nav>
    <main>
        <section class="user-profile">
            <div class="user-info">
                <h2>Current User Information</h2>
                <p>Email: <?= $_SESSION['user_email']; ?></p>
                <p>Nickname: <?= $_SESSION['user_nickname']; ?></p>
            </div>
            <div class="user-profile-form">
                <div class="messages">
                    <?php
                    if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <div class="form-wrapper">
                    <form action="/update" method="POST">
                        <h2>Change Email</h2>
                        <input name="email" type="email" placeholder="New Email" required>
                        <button type="submit">Update Email</button>
                    </form>
                    <form action="/update" method="POST">
                        <h2>Change Nickname</h2>
                        <input name="nickname" type="text" placeholder="New Nickname" required>
                        <button type="submit">Update Nickname</button>
                    </form>
                    <form action="/update" method="POST">
                        <h2>Change Password</h2>
                        <input name="password" type="password" placeholder="New Password" required>
                        <button type="submit">Update Password</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>