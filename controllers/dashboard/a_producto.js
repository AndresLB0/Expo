
const API_PROD = SERVER + 'dashboard/productos.php?action=';
const ENDPOINT_LINEA=SERVER +'dashboard/linea.php?action=readAll';
fillSelect(ENDPOINT_LINEA, 'linea', null);
const ENDPOINT_PROVEE=SERVER +'dashboard/proveedor.php?action=readAll';
fillSelect(ENDPOINT_PROVEE, 'provee', null);
const ENDPOINT_PRESEN=SERVER +'dashboard/presentacion.php?action=readAll';
fillSelect(ENDPOINT_PRESEN, 'presentacion', null);
document.getElementById('precio').onchange=function(){
    var precio=document.getElementById('precio').value;
    var pvp=parseFloat(precio)*1.25;
   document.getElementById('precioiva').value= (parseFloat(precio)*1.13).toFixed(2);
   document.getElementById('preciopublico').value= pvp.toFixed(2);
   document.getElementById('preciopublicoiva').value= (parseFloat(pvp)*1.13).toFixed(2);
   }
document.getElementById('save-form').addEventListener('submit', function (event) {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
  (document.getElementById('id').value);
  // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
  saveRow(API_PROD,'create', 'save-form','m_productos.html');
});