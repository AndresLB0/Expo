document.addEventListener('DOMContentLoaded', function () {
    const ENDPOINT_PRODUCTO=SERVER +'dashboard/productos.php?action=readAll'
fillSelect(ENDPOINT_PRODUCTO, 'productos', null);
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    M.Sidenav.init(document.querySelectorAll('.sidenav'));
    M.Datepicker.init(document.querySelectorAll('.datepicker'), {
        format: 'dd/mm/yyyy',
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
});