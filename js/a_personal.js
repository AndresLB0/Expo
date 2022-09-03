

const API_PERSO = SERVER + 'dashboard/usuarios.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
  readRows(API_PERSO);
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    M.FormSelect.init(document.querySelectorAll('select'));
});
