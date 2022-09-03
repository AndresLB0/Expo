
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
      <nav><div class="nav-wrapper"><a href="dashboard.html" class="boticono hide-on-med-and-down"><span
class="left material-icons md-38">arrow_back</span></a><a href="#" data-target="mobile-demo"
class="sidenav-trigger"><i class="material-icons">menu</i></a>
<ul class="right hide-on-med-and-down">
<li><a href="m_personal.html">personal</a></li>
<li><a href="m_proveedor.html">proveedores</a></li>
<li><a href="m_producto.html">productos</a></li>
<li><a href="m_pedido.html">pedidos</a></li>
<li><a href="m_cliente.html">clientes</a></li>
<li><a class="dropdown-trigger" href="#" data-target="mobile-dropdown">
    <i class="material-icons">verified_user</i>Cuenta: <b>${response.username}</b>
</a>
</li>
</ul>
</div></nav>
    </div>
    <ul class="sidenav" id="mobile-demo"
    <li><img src="../imagenes/logo/fatyssa 2.jpg" width="100%" alt="logo de fatyssa"></li>
<li><a href="m_personal.html">personal</a></li>
<li><a href="m_proveedor.html">proveedores</a></li>
<li><a href="m_producto.html">productos</a></li>
<li><a href="m_pedido.html">pedidos</a></li>
<li><a href="m_cliente.html">clientes</a></li>
<li>
<a class="dropdown-trigger" href="#" data-target="mobile-dropdown">
    <i class="material-icons">verified_user</i>Cuenta: <b>${response.username}</b>
</a>
</li></ul >`;
                        document.querySelector('header').innerHTML = menu;
                        M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
                        M.Sidenav.init(document.querySelectorAll('.sidenav'));

                    } else {
                        sweetAlert(3, response.exception, 'index.html');
                    }
                } else {
                    location.href = 'index.html';
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
});