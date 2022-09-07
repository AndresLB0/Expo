
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
readRows(API_PERSO)
});
function fillTable(dataset) {
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