const API_CONFU = SERVER + 'dashboard/personal.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    M.Tabs.init(document.querySelectorAll('.tabs', {
        swipeable: true
    }));
    let params = new URLSearchParams(location.search);
    // Se obtienen los datos localizados por medio de las variables.
    const ID = params.get('id');
    const NAME = params.get('nombre');
    // Se llama a la función que muestra los productos de la categoría seleccionada previamente.
    personalCargo(ID, NAME);
});
function personalCargo(id,cargo) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_cargo', id);
    // Petición para solicitar los productos de la categoría seleccionada.
    fetch(API_CONFU + 'readPersonaCargo', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    let content = '';
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se crean y concatenan las tarjetas con los datos de cada producto.
                        content += `
                        <tr>
                            <td>${row.nombre}</td>
                            <td>${row.usuario}</td>
                            <td>${row.dui}</td>
                            <td>${row.telefono}</td>
                            <td>
                                <a onclick="openUpdate(${row.id_personal})" class="btn-floating blue tooltipped" data-tooltip="Actualizar">
                                    <i class="material-icons">mode_edit</i>
                                </a>
                                <a onclick="openDelete(${row.id_personal})" class="btn-floating red tooltipped" data-tooltip="Eliminar">
                                    <i class="material-icons">delete</i>
                                </a>
                            </td>
                        </tr>
                    `
                    pestania+=`<li class="tab col s3 m3 l2"><a href="#${row.id_cargo}">${row.nombre_cargo}</a></li>`
                    });
                    // Se asigna como título la categoría de los productos.
                    document.getElementById('tabs-swipe-demo').innerHTML =pestania;
                    // Se agregan las tarjetas a la etiqueta div mediante su id para mostrar los productos.
                    document.getElementById('perso').innerHTML = content;
                    // Se inicializa el componente Material Box para que funcione el efecto Lightbox.
                    M.Materialbox.init(document.querySelectorAll('.materialboxed'));
                    // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
                    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                } else {
                    // Se presenta un mensaje de error cuando no existen datos para mostrar.
                    document.getElementById('title').innerHTML = `<i class="material-icons small">cloud_off</i><span class="red-text">${response.exception}</span>`;
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

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