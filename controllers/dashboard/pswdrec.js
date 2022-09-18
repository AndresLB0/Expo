const API_PERSO = SERVER + 'dashboard/usuarios.php?action=';
    document.getElementById('recovery-pswd').addEventListener('submit', function (event) {
        // Se evita recargar la página web después de enviar el formulario.
        event.preventDefault();
        document.getElementById('asunto').value='recuperar contraseña';
        document.getElementById('mensaje').value='ha solicitado un cambio de contraseña, regrese a la pagina e inserte el sigiente condigo para continuar';
        // Petición para actualizar la contraseña.
        fetch(API_PERSO + 'pswdReco', {
            method: 'post',
            body: new FormData(document.getElementById('recovery-pswd'))
        }).then(function (request) {
            // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
            if (request.ok) {
                // Se obtiene la respuesta en formato JSON.
                request.json().then(function (response) {
                    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                    if (response.status) {
                        // Se muestra un mensaje de éxito.
                        sweetAlert(1, response.message,'forget.html');
                    } else {
                        sweetAlert(2, response.exception, null);
                    }
                });
            } else {
                console.log(request.status + ' ' + request.statusText);
            }
        });
    });

  