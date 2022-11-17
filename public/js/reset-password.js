/**
 * User login.
 */
"use strict";

const form = document.getElementById("reset-password-form");
const email = document.getElementById("email");
const errorSubmission = document.getElementById("error-submission");

form.addEventListener("submit", (e) => {
    e.preventDefault();
    errorSubmission.classList.add("hidden");

    const emailValue = email.value;

    try {
        API.resetPasswordRequest(emailValue)
            .then((res) => {
                alert("Successful... A mail containing your new password has been sent to your email.");
                let url = "/";
                window.location = url;
            })
            .catch((err) => {
                errorSubmission.classList.remove("hidden");
                errorSubmission.textContent = "Password reset failed!";
            });
    } catch (error) {
        errorSubmission.classList.remove("hidden");
        errorSubmission.textContent = "Password reset failed!";
    }
});
