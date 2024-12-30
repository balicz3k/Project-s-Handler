<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Projects Handler</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Avenger:wght@400&display=swap" />
    <link rel="stylesheet" href="public/styles/login-register-styles.css" />
</head>
<body>
    <div class="logo-section">
        <img class="PH-logo" src="public/assets/ProjectsHandler-logo.png" alt="ProjectHandler">
    </div>
    <div class="main-container">
        <div class="login-section">
            <div class="login-section-header">
                <span class="log-in">Log in</span>
                <div class="have-account-login">
                    <div class="already-have-account">
                        <span class="new-here">New here?</span>
                        <a href="register" class="sign-up-for-free">Sign up for free</a>
                    </div>
                </div>
            </div>
            <form class="login-form" action="login" method="POST">
                <div class="email-input-frame">
                    <div class="mail-info"><span class="label">Email address</span></div>
                    <input type="text" name="email" class="mail-input" required>
                </div>
                <div class="password-input-frame">
                    <div class="password-info">
                        <span class="label">Password</span>
                        <span class="password-hide-see">Hide</span>
                    </div>
                    <input type="password" name="password" class="password-input" required>
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
                    <span class="sign-up">Log in</span>
                </button>
            </form>
            <div class="social-media-buttons">
                <button class="facebook-button">
                    <img class="facebook-social-icon" src="public/assets/facebook-logo.png" alt="Facebook">
                </button>
                <button class="google-button">
                    <img class="google-social-icon" src="public/assets/google-logo.png" alt="Google">
                </button>
            </div>
        </div>
    </div>
</body>
</html>