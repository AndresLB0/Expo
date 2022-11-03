const API_CLIENTE = SERVER + 'dashboard/clientes.php?action=';
const ENDPOINT_ESPECI=SERVER +'dashboard/especialidad.php?action=readAll';

document.addEventListener('DOMContentLoaded', function () {
  fillSelect(ENDPOINT_ESPECI, 'especi', null);
    var instances = M.Datepicker.init(document.querySelectorAll('.datepicker'), {
      format: 'yyyy-mm-dd',
      defaultDate: new Date(),
      setDefaultDate: true,
      i18n: {
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Juni', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        monthsShort: ['ene', 'Feb', 'Mar', 'Abr', 'Mayo', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      }
    });
    // menu parte 1
    var instances = M.Sidenav.init(document.querySelectorAll('.sidenav'));
  });
  document.getElementById('save-form').addEventListener('submit', function (event) {

    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('id').value);
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_CLIENTE,'createMedi', 'save-form','JavaScript:history.back()');
  });