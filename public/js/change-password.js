/**
 * User login.
 */
"use strict";

const form = document.getElementById("reset-password-form");
const oldPassword = document.getElementById("old_password");
const newPassword = document.getElementById("new_password");
const confirmNewPassword = document.getElementById("confirm_new_password");
const errorPasswordMismatch = document.getElementById(
    "error-password-mismatch"
);
const errorSubmission = document.getElementById("error-submission");

form.addEventListener("submit", (e) => {
    e.preventDefault();
    errorSubmission.classList.add("hidden");
    if (newPassword.value !== confirmNewPassword.value) {
        errorPasswordMismatch.classList.remove("hidden");
        return;
    } else {
        errorPasswordMismatch.classList.add("hidden");
    }

    const oldPasswordValue = oldPassword.value;
    const newPasswordValue = newPassword.value;
    const confirmedNewPasswordValue = confirmNewPassword.value;

    try {
        API.changePassword(
            oldPasswordValue,
            newPasswordValue,
            confirmedNewPasswordValue
        )
            .then((res) => {
                let { meta, data } = res;
                const search = window.location.search;
                const match = search.match(/url=([^=&]+)/);
                localStorage.setItem("init_time", Date.now());
                localStorage.setItem("jwt", meta.token);
                alert(res.message);
                let url = "/admin/";
                window.location = url;
            })
            .catch((err) => {
                errorSubmission.classList.remove("hidden");
                errorSubmission.textContent = "Password change failed!";
                console.error(err);
            });
    } catch (error) {
        errorSubmission.classList.remove("hidden");
        errorSubmission.textContent = "Failed to change password!";
        console.error(error);
    }
});
