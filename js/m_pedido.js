API_PEDIDO=SERVER+'dashboard/pedido.php?action='
ENDPOINT_ZONA=SERVER+'dashboard/zonas.php?action=readAll'
fillTabs(ENDPOINT_ZONA,'tabs-swipe-demo','ancla')

function readTable(zona) {
  // Se abre la caja de diálogo (modal) que contiene el formulario.
  // Se define un objeto con los datos del registro seleccionado.
  const data = new FormData();
  data.append('id_zona',zona);
  // Petición para obtener los datos del registro solicitado.
  fetch(API_PEDIDO + 'zonaPedido', {
      method: 'post',
      body: data
  }).then(function (request) {
      // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
      if (request.ok) {
          // Se obtiene la respuesta en formato JSON.
          request.json().then(function (response) {
              // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
              if (response.status) {
                  // Se inicializan los campos del formulario con los datos del registro seleccionado.
                 fillTable(response.dataset)
              } else {
                  sweetAlert(2, response.exception, null);
              }
          });
      } else {
          console.log(request.status + ' ' + request.statusText);
      }
  });
}


