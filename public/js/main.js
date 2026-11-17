document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", (e) => {
            const pass = form.querySelector("input[type='password']");
            if (pass && pass.value.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                e.preventDefault();
            }
        });
    });
});