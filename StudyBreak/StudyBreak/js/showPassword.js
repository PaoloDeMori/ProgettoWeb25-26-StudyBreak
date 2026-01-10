document.addEventListener("DOMContentLoaded", () => {
    const toggleButtons = document.querySelectorAll(".toggle-password");

    toggleButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const passwordInput = btn.parentElement.querySelector("input");
            const toggleIcon = btn.querySelector("img");

            const isPassword = passwordInput.type === "password";

            passwordInput.type = isPassword ? "text" : "password";

            toggleIcon.src = isPassword
                ? "/StudyBreak/StudyBreak/img/icons/show.svg"
                : "/StudyBreak/StudyBreak/img/icons/hashed.svg";

            toggleIcon.alt = isPassword ? "hide password" : "show password";
        });
    });
});