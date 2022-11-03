const ENDPOINT_CARGO=SERVER +'dashboard/cargo.php?action=readAll';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
readRows(API_PERSO);
let options = {
    dismissible: false,
}
M.Modal.init(document.querySelectorAll('.modal'), options);
});
function fillTable(dataset) {
    document.querySelector(".preloader").style.display = "none";
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
        <tr>
        <td>${row.nombre}</td>
        <td>${row.usuario}</td>
        <td>${row.dui}</td>
        <td>${row.email}</td>
        <td>${row.nombre_cargo}</td>
        <td>
            <a onclick="openUpdate(${row.id_personal})" class="btn-floating blue tooltipped" data-tooltip="Actualizar">
                <i class="material-icons">mode_edit</i>
            </a>
            <a onclick="openDelete(${row.id_personal})" class="btn-floating red tooltipped" data-tooltip="Eliminar">
                <i class="material-icons">delete</i>
            </a>
        </td>
    </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('perso').innerHTML = content;
    // Se inicializa el componente Material Box para que funcione el efecto Lightbox.
    M.Materialbox.init(document.querySelectorAll('.materialboxed'));
    // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}// Se inicializa el componente Material Box para que funcione el efecto Lightbox.
function openReport() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'Reportes/personal.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}
function openDelete(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id', id);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete(API_PERSO, data);
}
document.getElementById('search-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda. Se encuentra en el archivo components.js
    searchRows(API_PERSO,'search-form');
});
function openUpdate(id) {
    document.querySelector(".preloader").style.display = "block";
    // Se abre la caja de diálogo (modal) que contiene el formulario.
    M.Modal.getInstance(document.getElementById('update-modal')).open();
    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Actualizar usuario';
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_PERSO + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del registro seleccionado.
                    document.getElementById('id').value = response.dataset.id_personal;
                    document.getElementById('nombre').value = response.dataset.nombre;
                    document.getElementById('email').value = response.dataset.email;
                    document.getElementById('dui').value = response.dataset.dui;
                    document.getElementById('telefono').value = response.dataset.telefono;
                    document.getElementById('direccion').value = response.dataset.direccion;
                    fillSelect(ENDPOINT_CARGO, 'cargo',response.dataset.id_cargo);
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();
                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
document.getElementById('save-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('id').value);
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_PERSO,'update', 'save-form',null);
    M.Modal.getInstance(document.getElementById('update-modal')).close();
  });