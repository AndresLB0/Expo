const API_PERSO = SERVER + 'dashboard/usuarios.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    fetch(API_PERSO + 'getUser', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se revisa si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
                if (response.session) {
                    // Se comprueba si la respuesta es satisfactoria, de lo contrario se direcciona a la página web principal.
                    if (response.status) {
                        const menu = `<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper"><a href="dashboard.html" class="boticono hide-on-med-and-down"><img src="../imagenes/icono/sgvm.png" height="58px" width="64px" alt=""></a><a href="#" data-target="mobile-demo"
                class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="m_personal.html">Usuarios</a></li>
                <li><a href="m_proveedor.html">Proveedores</a></li>
                <li><a href="m_producto.html">Productos</a></li>
                <li><a href="m_pedido.html">Pedidos</a></li>
                <li><a href="m_cliente.html">Clientes</a></li>
                <li><a class="dropdown-trigger" href="#" data-target="desktop-dropdown">
                        <i class="material-icons">verified_user</i>Cuenta: <b>${response.username}</b>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <ul id="desktop-dropdown" class="dropdown-content">
        <li><a href="profile.html"><i class="material-icons">face</i>Editar perfil</a></li>
        <li><a href="password.html"><i class="material-icons">lock</i>Cambiar clave</a></li>
        <li><a onclick="logOut()"><i class="material-icons">clear</i>Salir</a></li>
    </ul>
</div>
<ul class="sidenav" id="mobile-demo" <li><img src="../imagenes/logo/sgvm.jpg" width="100%" alt="logo de fatyssa">
    </li>
    <li><a href="m_personal.html">Usuarios</a></li>
    <li><a href="m_proveedor.html">Proveedores</a></li>
    <li><a href="m_producto.html">Productos</a></li>
    <li><a href="m_pedido.html">Pedidos</a></li>
    <li><a href="m_cliente.html">Clientes</a></li>
    <li>
        <a class="dropdown-trigger" href="#" data-target="mobile-dropdown">
            <i class="material-icons">verified_user</i>Cuenta: <b>${response.username}</b>
        </a>
    </li>
</ul>
<ul id="mobile-dropdown" class="dropdown-content">
    <li><a href="profile.html"><i class="material-icons">face</i>Editar perfil</a></li>
    <li><a href="password.html"><i class="material-icons">lock</i>Cambiar clave</a></li>
    <li><a onclick="logOut()"><i class="material-icons">clear</i>Salir</a></li>
</ul>`;
                        document.querySelector('header').innerHTML = menu;
                        M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
                        M.Sidenav.init(document.querySelectorAll('.sidenav'));

                    } else {
                        sweetAlert(3, response.exception, '../index.html');
                    }
                } else {
                    location.href = '../index.html';
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
});

var timer, currSeconds = 0;

function resetTimer() {

    /* Hide the timer text */

    /* Clear the previous interval */
    clearInterval(timer);

    /* Reset the seconds of the timer */
    currSeconds = 0;

    /* Set a new interval */
    timer =
        setInterval(startIdleTimer, 1000);


}

// Define the events that
// would reset the timer
window.onload = resetTimer;
window.onmousemove = resetTimer;
window.onmousedown = resetTimer;
window.ontouchstart = resetTimer;
window.onclick = resetTimer;
window.onkeypress = resetTimer;

function startIdleTimer() {

    /* Increment the
        timer seconds */
    currSeconds++;

    if (currSeconds ==300) {
        fetch(API_PERSO + 'logOut', {
            method: 'get'
        }).then(function (request) {
            // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
            if (request.ok) {
                // Se obtiene la respuesta en formato JSON.
                request.json().then(function (response) {
                    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                    if (response.status) {
                        sweetAlert(1, response.message, '../index.html');
                    } else {
                        sweetAlert(2, response.exception, null);
                    }
                });
            } else {
                console.log(request.status + ' ' + request.statusText);
            }
        });
    }
}
  