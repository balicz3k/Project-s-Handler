document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.login-form');
    form.addEventListener('input', validateForm);

    const passwordFields = document.querySelectorAll('input[type="password"]');
    const toggleButtons = document.querySelectorAll('.password-hide-see');

    toggleButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const passwordField = passwordFields[index];
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                button.style.textDecoration = 'line-through';
            } else {
                passwordField.type = 'password';
                button.style.textDecoration = 'none';
            }
        });
    });
});