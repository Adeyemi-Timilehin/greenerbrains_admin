/**
 * Create User
 *
 * Implements a simple password confirmation step
 *
 */
'use strict';

// const API = require('./api');

// function setupForm() {
const form = document.getElementById('regiter-form');
const email = document.getElementById('email');
const password = document.getElementById('password');
const name = document.getElementById('name');
const user_type = document.getElementById('user-type');
const confirmPassword = document.getElementById('confirm-password');
const errorPasswordMismatch =
    document.getElementById('error-password-mismatch');
const errorSubmission = document.getElementById('error-submission');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    errorSubmission.classList.add('hidden');
    if (password.value !== confirmPassword.value) {
        errorPasswordMismatch.classList.remove('hidden');
        return;
    } else {
        errorPasswordMismatch.classList.add('hidden');
    }

    const emailValue = email.value;
    const passwordValue = password.value;
    const nameValue = name.value;
    const type = user_type.value;

    API.createUser(nameValue, emailValue, passwordValue, type).
        then(() => {
            window.location.href = '/admin/content';
        }).
        catch((err) => {
            errorSubmission.classList.remove('hidden');
            errorSubmission.textContent = err.message;
            console.error(err);
        });
});
// }
