
document.addEventListener('DOMContentLoaded', function () {
    //   script para el combobox
    var instances = M.FormSelect.init(document.querySelectorAll('select'));
    // script para elejir fecha
    var instances = M.Datepicker.init(document.querySelectorAll('.datepicker'), {
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
    // script para pestañas
    var instances = M.Tabs.init(document.querySelector('.tabs', {
      swipeable: true,
    }));
    // menu parte 1
    var instances = M.Sidenav.init(document.querySelectorAll('.sidenav'));
  });
  
  //feacha y hora
  function reloj() {
    fecha = new Date();
    anno = fecha.getFullYear();
    mes = fecha.getMonth() + 1;
    dia = fecha.getDate();
    diasem = fecha.getDay();
    document.getElementById("hoy").innerHTML = dia + "/" + mes + '/' + anno;
    //hora actual
    tiempo = new Date();
    hora = tiempo.getHours();
    if (hora < 10) hora = "0" + hora
    min = tiempo.getMinutes();
    if (min < 10) min = "0" + min;
    horacompleta = hora + ":" + min;
    document.getElementById('hora').innerHTML = horacompleta;
    setTimeout('reloj()', 1000)
  }
  
  document.getElementById('menu').innerHTML = '<div class="nav-wrapper"><a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a><ul class="right hide-on-med-and-down"><li><a href="m_personal.html">personal</a></li><li><a href="m_proveedor.html">proveedores</a></li><li><a href="m_producto.html">productos</a></li><li><a href="m_pedido.html">pedidos</a></li><li><a href="m_cliente.html">clientes</a></li></ul></div>';
  document.getElementById('mobile-demo').innerHTML='<li><img src="../imagenes/logo/fatyssa 2.jpg" width="100%" alt="logo de fatyssa"></li><li><a href="m_personal.html">personal</a></li><li><a href="m_proveedor.html">proveedores</a></li><li><a href="m_producto.html">productos</a></li><li><a href="m_pedido.html">pedidos</a></li><li><a href="m_cliente.html">clientes</a></li>'