<?php
require('../helpers/dashboard_report.php');
require('../modelos/pedido.php');
require('../modelos/envio.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('tipo de envios');

// Se instancia el módelo Categorías para obtener los datos.
$envio = new envio;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($dataenvio = $envio->readAll()) {
    // Se establece un color de relleno para los encabezados.

    // Se recorren los registros ($datatipopedido) fila por fila ($rowtipopedido).
    foreach ($dataenvio as $rowenvio) {
        $pdf->setFillColor(100, 149, 237);
    
    // Se establece la fuente para los encabezados.
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, utf8_decode('tipo de envio: '.$rowenvio['tipo']), 1, 1, 'C', 1);
        $pdf->setFont('Times', 'B', 11);
        $pdf->setFillColor(80, 80, 200);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(60, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
    $pdf->cell(60, 10, utf8_decode('Zona'), 1, 0, 'C', 1);
    $pdf->cell(66, 10, utf8_decode('pago($)'), 1, 1, 'C', 1);
    // Se establece un color de relleno para mostrar el nombre de la categoría.
   
    // Se establece la fuente para los datos de los pedido.
    $pdf->setFont('Times', '', 11);
        // Se instancia el módelo pedido para procesar los datos.
        $pedido = new pedidos;
        // Se establece la categoría para obtener sus pedido, de lo contrario se imprime un mensaje de error.
        if ($pedido->setEnvio($rowenvio['id_envio'])) {
            // Se verifica si existen registros (pedido) para mostrar, de lo contrario se imprime un mensaje.
            if ($datapedido = $pedido->pedidoenvio()) {
                // Se recorren los registros ($datapedido) fila por fila ($rowpedido).
                foreach ($datapedido as $rowpedido) {
                    // Se imprimen las celdas con los datos de los pedido.
                    $pdf->cell(60, 10, utf8_decode($rowpedido['nombre']), 1, 0);
                    $pdf->cell(60, 10, $rowpedido['nombre_zona'], 1, 0);
                    $pdf->cell(66, 10, $rowpedido['total_pagar'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, utf8_decode('No hay envio para este pedido'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, utf8_decode('pedido incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, utf8_decode('No hay pedido para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método footer()
$pdf->output('I', 'pedido.pdf');
