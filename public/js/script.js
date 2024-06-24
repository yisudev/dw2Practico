document.addEventListener('DOMContentLoaded', () => {
    const createForm = document.getElementById('createForm');
    const updateForm = document.getElementById('updateForm');
    const deleteForm = document.getElementById('deleteForm');
    const loadDataBtn = document.getElementById('loadData');
    const dataBody = document.getElementById('dataBody');
    loadData();
// Función para validar formato de email
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Función para validar campos requeridos
function validateForm(nombre, apellido, cumple, email, celular) {
    if (nombre.trim() === '' || apellido.trim() === '' || cumple.trim() === '' || email.trim() === '' || celular.trim() === '') {
        alert('Por favor completa todos los campos.');
        return false;
    }

    if (!isValidEmail(email)) {
        alert('Por favor introduce un email válido.');
        return false;
    }

    return true;
}

// Evento para el formulario de Creación
createForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const nombre = document.getElementById('createNombre').value;
    const apellido = document.getElementById('createApellido').value;
    const cumple = document.getElementById('createCumple').value;
    const email = document.getElementById('createEmail').value;
    const celular = document.getElementById('createCelular').value;

    // Validar los campos antes de enviar la solicitud
    if (!validateForm(nombre, apellido, cumple, email, celular)) {
        return;
    }

    fetch('/api/create.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nombre, apellido, cumple, email, celular })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadData(); // Recargar los datos después de una creación exitosa
        createForm.reset(); // Opcional: Limpiar campos del formulario después del envío
    })
    .catch(error => console.error('Error:', error));
});

// Evento para el formulario de Actualización
updateForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const id = document.getElementById('updateId').value;
    const nombre = document.getElementById('updateNombre').value;
    const apellido = document.getElementById('updateApellido').value;
    const cumple = document.getElementById('updateCumple').value;
    const email = document.getElementById('updateEmail').value;
    const celular = document.getElementById('updateCelular').value;

    // Validar los campos antes de enviar la solicitud
    if (!validateForm(nombre, apellido, cumple, email, celular)) {
        return;
    }

    fetch('/api/update.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, nombre, apellido, cumple, email, celular })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadData(); // Recargar los datos después de una actualización exitosa
        updateForm.reset(); // Opcional: Limpiar campos del formulario después del envío
    })
    .catch(error => console.error('Error:', error));
});

// Evento para el formulario de Eliminación
deleteForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const id = document.getElementById('deleteId').value;

    // Validar que el ID no esté vacío
    if (id.trim() === '') {
        alert('Por favor introduce un ID válido.');
        return;
    }

    fetch('/api/delete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadData(); // Recargar los datos después de una eliminación exitosa
        deleteForm.reset(); // Opcional: Limpiar campos del formulario después del envío
    })
    .catch(error => console.error('Error:', error));
});


    function loadData() {
        fetch('/api/read.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            dataBody.innerHTML = ''; // Clear previous data
            data.forEach(row => {
                dataBody.innerHTML += `
                    <tr>
                        <td>${row.id}</td>
                        <td>${row.doce_nombre}</td>  <!-- Cambiado a doce_nombre -->
                        <td>${row.doce_apellido}</td>  <!-- Cambiado a doce_apellido -->
                        <td>${row.per_cumple}</td>  <!-- Cambiado a per_cumple -->
                        <td>${row.per_mail}</td>  <!-- Cambiado a per_mail -->
                        <td>${row.doce_cel}</td>  <!-- Asumiendo que 'celular' está correcto -->
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Error:', error));
    }
    
});
