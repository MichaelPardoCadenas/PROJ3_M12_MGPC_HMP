document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('http://localhost/projecte3/backend/api/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username, password })
            });

            const result = await response.json();

            if (result.status === 'success') {
                localStorage.setItem('user_id', result.user_id);
                window.location.href = 'index.html';
            } else {
                alert(result.message);
            }
        } catch (error) {
            alert('Error al conectar con el servidor.');
            console.error(error);
        }
    });
});
