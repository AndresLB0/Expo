<?php
// Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
if (isset($_GET['id'])) {
    require('../helpers/dashboard_report.php');
    require('../modelos/clientes.php');
    require('../modelos/pedido.php');
    // Se instancia el módelo marca para procesar los datos.
    $cliente = new clientes;

    // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
    if ($cliente->setIdCl($_GET['id'])) {
        // Se verifica si la categoría del parametro existe, de lo contrario se direcciona a la página web de origen.
        if ($rowcliente = $cliente->readOne()) {
            // Se instancia la clase para crear el reporte.
            $pdf = new Report;
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('pedido de  ' . $rowcliente['nombre']);
            // Se instancia el módelo pedidos para procesar los datos.
            $pedido = new pedidos;
            if ($pedido->setIdcliente($rowcliente['id_cliente'])) {
                // Se verifica si existen registros (pedidos) para mostrar, de lo contrario se imprime un mensaje.
                if ($datapedidos = $pedido->pedidocliente()) {
                    // Se establece un color de relleno para los encabezados.
                    $pdf->setFillColor(80, 80, 200);
                // Se verifica si existen registros (pedidos) para mos
                    // Se recorren los registros ($datapedidos) fila por fila ($rowpedido).
                    foreach ($datapedidos as $rowpedido) {
                    // Se establece la fuente para los encabezados.
                    $pdf->setFont('Times', 'B', 11);  
                    $pdf->SetTextColor(0,0,0);
                    // Se imprimen las celdas con la linea de arriba siendo los campos y la que esta abajo es el dato correspondiente al campo
                    $pdf->cell(60, 10, utf8_decode('producto'), 0, 0, 'C', 1);
                    $pdf->cell(60, 10, utf8_decode($rowpedido['nombre_producto']), 0, 1);
                    $pdf->cell(60, 10, utf8_decode('Precio c/u (US$)'), 0, 0, 'C', 1);
                    $pdf->cell(50, 10, $rowpedido["precio_iva"], 0, 1);
                    $pdf->cell(60, 10, utf8_decode('cantidad'), 0, 0, 'C', 1);
                    $pdf->cell(40, 10, $rowpedido['cantidad'], 0, 1);
                    $pdf->cell(60, 10, utf8_decode('fecha'),0, 0, 'C', 1);
                    $pdf->cell(125, 10, $rowpedido['fecha'], 0, 1);
                    $pdf->cell(60, 10, utf8_decode('zona'),'B', 0, 'C', 1);
                    $pdf->cell(125, 10, $rowpedido['nombre_zona'], 'B', 1);
                    $pdf->Ln(4);
                    // Se establece la fuente para los datos de los pedid
                }
             } else {
                    $pdf->cell(0, 10, utf8_decode('No hay pedidos para esta categoría'), 1, 1);
                }
                // Se envía el documento al navegador y se llama al método footer()
                $pdf->output('I', 'categoria.pdf');
            } else {
                //header('location: ../../../views/dashboard/categorias.php');
            }
        } else {
            //header('location: ../../../views/dashboard/categorias.php');
        }
    } else {
        //header('location: ../../../views/dashboard/categorias.php');
    }
} else {
    //header('location: ../../../views/dashboard/categorias.php');
}
