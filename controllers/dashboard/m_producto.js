const API_PROD = SERVER + 'dashboard/productos.php?action=';
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows(API_PROD);
    M.Tabs.init(document.querySelector('.tabs',{
      swipeable:true,
    }));
});
      function openReport() {
        // Se establece la ruta del reporte en el servidor.
        let url = SERVER + 'Reportes/productos_presentacion.php';
        // Se abre el reporte en una nueva pestaña del navegador web.
        window.open(url);
      }

    
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.


// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
                <td>${row.id_producto}</td>
                <td>${row.nombre_producto}</td>
                <td>${row.descripcion}</td>
                <td>${row.reg_san}</td>
                <td>${row.precio_iva}</td>
                <td>${row.presentacio}</td>
                <td>
                    <a onclick="openUpdate(${row.id_producto})" class="btn-floating blue tooltipped" data-tooltip="Actualizar">
                        <i class="material-icons">mode_edit</i>
                    </a>
                    <a onclick="openDelete(${row.id_producto})" class="btn-floating red tooltipped" data-tooltip="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    <a onclick="openReport(${row.id_producto})" class="btn-floating indigo tooltipped" data-tooltip="Reporte">
                        <i class="material-icons">assignment</i>
                    </a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('produ').innerHTML = content;
    // Se inicializa el componente Material Box para que funcione el efecto Lightbox.
    // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}
