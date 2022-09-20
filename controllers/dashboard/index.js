// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PERSO = SERVER + 'dashboard/usuarios.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Petición para consultar si existen usuarios registrados.
    fetch(API_PERSO + 'readUsers', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si existe una sesión, de lo contrario se revisa si la respuesta es satisfactoria.
                if (response.session) {
                    fetch(API_PERSO + 'logOut', {
                        method: 'get'
                    }).then(function (request) {
                        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
                        if (request.ok) {
                            // Se obtiene la respuesta en formato JSON.
                            request.json().then(function (response) {
                                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                                if (response.status) {
                                 location.href='index.html'
                                } else {
                                    sweetAlert(2, response.exception, null);
                                }
                            });
                        } else {
                            console.log(request.status + ' ' + request.statusText);
                        }
                    });
                } else if (response.status) {
                    sweetAlert(4, 'Debe autenticarse para ingresar', null);
                } else {
                    sweetAlert(3, response.exception, 'singup.html');
                    
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
    // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
});

// Método manejador de eventos que se ejecuta cuando se envía el formulario de iniciar sesión.
document.getElementById('session-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Petición para revisar si el administrador se encuentra registrado.
    fetch(API_PERSO + 'logIn', {
        method: 'post',
        body: new FormData(document.getElementById('session-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
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
function reloj() {
    fecha = new Date();
    anno = fecha.getFullYear();
    mes = fecha.getMonth() + 1;
    dia = fecha.getDate();
    diasem = fecha.getDay();
    sec=fecha.getSeconds();
    if (sec==10) {
        location.href='changepswd.html'
    }
    setTimeout('reloj()', 1000)
  }