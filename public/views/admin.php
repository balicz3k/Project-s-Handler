<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_role'] !== 'admin') {
    header('Location: /login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/public/styles/general-styles.css">
    <link rel="stylesheet" href="/public/styles/admin-styles.css">
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
        <section class="admin-panel">
            <table>
                <thead>
                <tr>
                    <th>Nickname</th>
                    <th>Email</th>
                    <th>Projects</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['nickname']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['project_count']; ?></td>
                        <td><?= $user['role']; ?></td>
                        <td>
                            <form action="/updateRole" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">
                                <select name="role" class="role-selector">
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                                <button type="submit" class="update-button">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="/deleteUser" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>