/**
 * User login.
 */
'use strict';


const form = document.getElementById('login-form');
const email = document.getElementById('email');
const password = document.getElementById('password');
const errorSubmission = document.getElementById('error-submission');


form.addEventListener('submit', (e) => {
    e.preventDefault();
    errorSubmission.classList.add('hidden');

    const emailValue = email.value;
    const passwordValue = password.value;

    API.login(emailValue, passwordValue).
        then(() => {
            const search = window.location.search;
            const match = search.match(/url=([^=&]+)/);

            localStorage.setItem("init_time", Date.now());
            let url = '/admin/content';
            if (match) {
                url = decodeURIComponent(match[1]);
            }

            window.location.href = url;
        }).
        catch((err) => {
            errorSubmission.classList.remove('hidden');
            errorSubmission.textContent = err.message;
            console.error(err);
        });
});

