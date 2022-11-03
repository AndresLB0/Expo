// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PERSO = SERVER + 'dashboard/usuarios.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
});

// Método manejador de eventos que se ejecuta cuando se envía el formulario de cambiar contraseña.
document.getElementById('password-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Petición para actualizar la contraseña.
    fetch(API_PERSO + 'changePswd', {
        method: 'post',
        body: new FormData(document.getElementById('password-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se muestra un mensaje de éxito.
                    sweetAlert(1, response.message, 'token.html');
                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
});
    