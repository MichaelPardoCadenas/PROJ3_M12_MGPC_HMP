document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('register-form');

    registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const username = document.getElementById('new-username').value;
        const password = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (password !== confirmPassword) {
            alert("Las contraseñas no coinciden. Intenta nuevamente.");
            return;
        }

        try {
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username, password })
            });

            const result = await response.json();

            if (result.status === 'success') {
                alert("Registro exitoso. Ya puedes iniciar sesión.");
                window.location.href = "login.html";
            } else {
                alert(result.message || "No se pudo completar el registro.");
            }
        } catch (error) {
            alert("Error al conectar con el servidor.");
            console.error(error);
        }
    });
});
