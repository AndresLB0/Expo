

const API_PERSO = SERVER + 'dashboard/usuarios.php?action=';
const ENDPOINT_CARGO=SERVER +'dashboard/cargo.php?action=readAll'
fillSelect(ENDPOINT_CARGO, 'cargo', null);
document.getElementById('save-form').addEventListener('submit', function (event) {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  // Se define una variable para establecer la acción a realizar en la API.
  let action = '';
  // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
  (document.getElementById('id').value) ? action = 'update' : action = 'create';
  // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
  saveRow(API_PERSO, action, 'save-form');
});
