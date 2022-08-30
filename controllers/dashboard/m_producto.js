document.addEventListener('DOMContentLoaded', function() {
    var instances = M.Tabs.init(document.querySelector('.tabs',{
        swipeable:true,
      }));
      var instances = M.Sidenav.init(document.querySelectorAll('.sidenav'));
      });
      function openReport() {
        // Se establece la ruta del reporte en el servidor.
        let url = SERVER + 'Reportes/productos_presentacion.php';
        // Se abre el reporte en una nueva pestaña del navegador web.
        window.open(url);
      }