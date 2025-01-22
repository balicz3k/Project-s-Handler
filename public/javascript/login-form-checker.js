document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.querySelector('.mail-input');
    const passwordInput = document.querySelector('.password-input');
    const loginButton = document.querySelector('.sign-in-button');

    function checkInputs() {
        let isValid = true;

        if (emailInput.value.trim() === '') {
            emailInput.classList.add('input-error');
            emailInput.classList.remove('input-success');
            isValid = false;
        } else {
            emailInput.classList.add('input-success');
            emailInput.classList.remove('input-error');
        }

        if (passwordInput.value.trim() === '') {
            passwordInput.classList.add('input-error');
            passwordInput.classList.remove('input-success');
            isValid = false;
        } else {
            passwordInput.classList.add('input-success');
            passwordInput.classList.remove('input-error');
        }

        if (isValid) {
            loginButton.classList.add('button-enabled');
        } else {
            loginButton.classList.remove('button-enabled');
        }
    }

    emailInput.addEventListener('input', checkInputs);
    passwordInput.addEventListener('input', checkInputs);
});