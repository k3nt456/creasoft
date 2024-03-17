
/* Configuración de la API */
const BASE_URL = 'http://127.0.0.1:8000/v1/';

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-1');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        const formData = {
            username: username,
            password: password
        };

        fetch(`${BASE_URL}auth/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                // Respuesta correcta
                localStorage.setItem('access_token', data.data.detail.access_token);
                localStorage.setItem('username', data.data.detail.user.name);
                window.location.href = '../panel/panel.html'; // Redireccionar a la página de panel
            } else {
                // Respuesta incorrecta
                alert(data.data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});