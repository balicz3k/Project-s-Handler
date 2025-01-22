function validateForm() {
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    const rePassword = document.querySelector('input[name="re-password"]');
    const nickname = document.querySelector('input[name="nickname"]');
    const submitButton = document.querySelector('.sign-in-button');

    let isValid = true;

    // Email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value)) {
        email.classList.add('input-error');
        email.classList.remove('input-success');
        isValid = false;
    } else {
        email.classList.add('input-success');
        email.classList.remove('input-error');
    }

    // Password strength validation
    const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|\W)).+$/;
    if (!strongPasswordPattern.test(password.value)) {
        password.classList.add('input-error');
        password.classList.remove('input-success');
        isValid = false;
    } else {
        password.classList.add('input-success');
        password.classList.remove('input-error');
    }

    // Password match validation
    if (password.value !== rePassword.value) {
        rePassword.classList.add('input-error');
        rePassword.classList.remove('input-success');
        isValid = false;
    } else {
        rePassword.classList.add('input-success');
        rePassword.classList.remove('input-error');
    }

    // Nickname validation (assuming it should not be empty)
    if (nickname.value.trim() === "") {
        nickname.classList.add('input-error');
        nickname.classList.remove('input-success');
        isValid = false;
    } else {
        nickname.classList.add('input-success');
        nickname.classList.remove('input-error');
    }

    // Enable or disable the submit button
    if (isValid) {
        submitButton.classList.add('button-enabled');
    } else {
        submitButton.classList.remove('button-enabled');
    }

    return isValid;
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.login-form');
    form.addEventListener('input', validateForm);
});