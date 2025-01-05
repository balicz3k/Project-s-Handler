<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Projects Handler</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Avenger:wght@400&display=swap" />
    <link rel="stylesheet" href="/public/styles/login-register-styles.css" />
</head>
<body>
<div class="logo-section">
    <img class="PH-logo" src="/public/assets/ProjectsHandler-logo.png" alt="ProjectHandler">
</div>
<div class="main-container">
    <div class="login-section">
        <div class="login-section-header">
            <span class="log-in">Create an account</span>
            <div class="have-account-login">
                <div class="already-have-account">
                    <span class="new-here">Already have an account? </span>
                    <a href="/login" class="sign-up-for-free">Log in</a>
                </div>
            </div>
        </div>
        <form class="login-form" action="/register" method="POST">
            <div class="email-input-frame">
                <div class="mail-info"><span class="label">What should we call you?</span></div>
                <input type="text" name="nickname" class="mail-input" required>
            </div>
            <div class="email-input-frame">
                <div class="mail-info"><span class="label">What’s your email?</span></div>
                <input type="text" name="email" class="mail-input" required>
            </div>
            <div class="password-input-frame">
                <div class="password-info">
                    <span class="label">Create a password</span>
                    <span class="password-hide-see">Hide</span>
                </div>
                <input type="password" name="password" class="password-input" required>
            </div>
            <div class="password-input-frame">
                <div class="password-info">
                    <span class="label">Confirm a password</span>
                </div>
                <input type="password" name="re-password" class="password-input" required>
            </div>
            <div class="messages">
                <?php
                if(isset($messages)){
                    foreach($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <button class="sign-in-button" type="submit">
                <span class="sign-up">Create an account</span>
            </button>
        </form>
    </div>
</div>
</body>
</html>