/* Configuración de la API */
const BASE_URL = 'http://127.0.0.1:8000/v1/';


/* Verificar el iniciio de sesión */
document.addEventListener('DOMContentLoaded', function () {
    // Función para obtener el nombre de usuario del LocalStorage
    function getUsername() {
        return localStorage.getItem('username');
    }

    // Función para verificar si hay una sesión activa y redirigir al inicio de sesión si no hay ninguna
    function checkSession() {
        if (!getUsername()) {
            // No hay una sesión activa, redirigir al inicio de sesión
            window.location.href = '../autentication/login.html';
        }
    }

    // Llamar a la función para verificar la sesión cuando se carga la página
    checkSession();
});

/* Reemplazar nombre por el guardado */
document.addEventListener('DOMContentLoaded', function () {
    // Función para obtener el nombre de usuario del LocalStorage
    function getUsername() {
        return localStorage.getItem('username') || 'Usuario';
    }

    // Función para reemplazar el texto en el navbar con el nombre de usuario
    function replaceUsername() {
        const navbarTitle = document.querySelector('.nav-title');
        navbarTitle.textContent = getUsername();
    }

    // Llamar a la función para reemplazar el nombre de usuario cuando se carga la página
    replaceUsername();
});

/* Cerrar sesión y redirigir */
document.addEventListener('DOMContentLoaded', function () {
    // Función para obtener el token de acceso del LocalStorage
    function getAccessToken() {
        return localStorage.getItem('access_token');
    }

    // Función para cerrar sesión y redirigir al inicio de sesión
    function logout() {
        const token = getAccessToken();

        fetch(`${BASE_URL}auth/logOut`, {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token
            }
        })
        .then(response => {
            if (response.ok) {
                // Eliminar datos del LocalStorage
                localStorage.removeItem('access_token');
                localStorage.removeItem('username');
                // Redirigir al inicio de sesión
                window.location.href = '../autentication/login.html';
            } else {
                // En caso de error al cerrar sesión
                console.error('Error al cerrar sesión');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Agregar evento de clic al botón de cerrar sesión
    const logoutButton = document.querySelector('.btn-logout');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault(); // Evita el comportamiento predeterminado del enlace
            logout(); // Llama a la función logout al hacer clic en el botón
        });
    }
});

/* Cargar data de la semana */
document.addEventListener("DOMContentLoaded", function() {
    const paginationForm = document.getElementById('paginationForm');
    paginationForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const initialDate = document.getElementById('initialDate').value;
        let finalDate = document.getElementById('finalDate').value;

        // Validar que la fecha final no sea mayor que hoy
        const today = new Date().toISOString().slice(0,10); // Formato YYYY-MM-DD
        if (finalDate > today) {
            alert('La fecha final no puede ser mayor que hoy.');
            return;
        }

        const perPage = document.getElementById('perPage').value;
        const page = document.getElementById('page').value;
        fetchData(initialDate, finalDate, perPage, page);
    });

    // Obtener la fecha del lunes de la semana actual
    const today = new Date();
    const dayOfWeek = today.getDay() || 7; // Si es domingo, devuelve 0, por lo tanto, cambia a 7
    const monday = new Date(today);
    monday.setDate(monday.getDate() - dayOfWeek + 1);
    const initialDate = monday.toISOString().slice(0,10); // Formato YYYY-MM-DD
    document.getElementById('initialDate').value = initialDate;

    // Obtener la fecha del domingo de la semana actual
    const sunday = new Date(today);
    sunday.setDate(sunday.getDate() - dayOfWeek + 7);
    const finalDate = sunday.toISOString().slice(0,10); // Formato YYYY-MM-DD
    document.getElementById('finalDate').value = finalDate;

    fetchData(initialDate, finalDate, 10, 1); // Inicialmente perPage es 10 y page es 1
});

function fetchData(initialDate, finalDate, perPage, page) {
    const token = localStorage.getItem('access_token');
    let apiUrl = `${BASE_URL}customers/dataCustomer?initial_date=${initialDate}&final_date=${finalDate}&revision_status=0&status=1&perPage=${perPage}&page=${page}`;

    if (initialDate && finalDate) {
        apiUrl += `&initial_date=${initialDate}&final_date=${finalDate}`;
    }

    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            displayData(data.data.detail);
            displayPagination(data.data.total_pages);
        } else {
            console.error('Error en la solicitud:', data.data.message);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
}

// Mostrar la data
function displayData(data) {
    const table = document.createElement('table');
    const tableHeader = `
        <tr>
            <th>Celular</th>
            <th>DNI</th>
            <th>Estado de revisión</th>
            <th>Fecha de solicitud</th>
            <th>Estado</th>
        </tr>
    `;
    let tableBody = '';

    data.forEach(customer => {
        tableBody += `
            <tr>
                <td data-label="Celular">${customer.cellphone}</td>
                <td data-label="DNI">${customer.dni}</td>
                <td data-label="Estado de revisión">${customer.revision_status_text}</td>
                <td data-label="Fecha de solicitud">${customer.created_at}</td>
                <td data-label="Estado">${customer.status_text}</td>
            </tr>
        `;
    });

    table.innerHTML = tableHeader + tableBody;
    document.getElementById('customerTable').innerHTML = '';
    document.getElementById('customerTable').appendChild(table);
}

// Paginación
function displayPagination(totalPages) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.addEventListener('click', () => {
            const perPage = document.getElementById('perPage').value;
            fetchData(perPage, i); // Cambiar perPage al seleccionado y page al número de página
        });
        pagination.appendChild(button);
    }
}

/* Exportar a Excel */
document.addEventListener("DOMContentLoaded", function() {
    // Código anterior...

    const exportButton = document.getElementById('exportButton');
    exportButton.addEventListener('click', function(event) {
        event.preventDefault();
        const initialDate = document.getElementById('initialDate').value;
        const finalDate = document.getElementById('finalDate').value;
        const perPage = document.getElementById('perPage').value;
        const page = document.getElementById('page').value;
        exportData(initialDate, finalDate, perPage, page);
    });
});

function exportData(initialDate, finalDate, perPage, page) {
    const token = localStorage.getItem('access_token');
    const apiUrl = `${BASE_URL}customers/dataCustomer/exportData?initial_date=${initialDate}&final_date=${finalDate}&revision_status=0&status=1&perPage=${perPage}&page=${page}`;

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token
        }
    })
    .then(response => {
        if (response.ok) {
            return response.blob(); // Convertir la respuesta a un objeto Blob
        } else {
            throw new Error('Error en la exportación:', response.statusText);
        }
    })
    .then(blob => {
        // Crear un objeto URL para el blob
        const url = window.URL.createObjectURL(blob);
        // Crear un enlace <a> para descargar el archivo
        const a = document.createElement('a');
        a.href = url;
        a.download = 'data_customers.xlsx'; // Nombre del archivo a descargar
        // Hacer clic en el enlace para iniciar la descarga
        a.click();
        // Liberar el objeto URL creado
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Error en la exportación:', error.message);
    });
}


