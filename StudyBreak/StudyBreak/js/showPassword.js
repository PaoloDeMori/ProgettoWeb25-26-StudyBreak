document.addEventListener("DOMContentLoaded", () => {
    const passwordInput = document.getElementById("password");
    const toggleBtn = document.getElementById("toggle-password");
    const toggleIcon = toggleBtn.querySelector("img");

    toggleBtn.addEventListener("click", () => {
        const isPassword = passwordInput.type === "password";

        passwordInput.type = isPassword ? "text" : "password";

        toggleIcon.src = isPassword
            ? "../public/img/icons/show.svg"
            : "../public/img/icons/hashed.svg";

        toggleIcon.alt = isPassword ? "hide password" : "show password";
    });
});