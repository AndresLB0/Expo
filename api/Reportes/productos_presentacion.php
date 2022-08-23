<?php
require('../helpers/dashboard_report.php');
require('../modelos/productos.php');
require('../modelos/presentacion.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('producto de la empresa');

// Se instancia el módelo Categorías para obtener los datos.
$presentacion = new presentacion;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($datapresentacion = $presentacion->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(80, 80, 200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(60, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
    $pdf->cell(50, 10, utf8_decode('Precio($)'), 1, 0, 'C', 1);
    $pdf->cell(40, 10, utf8_decode('Exitencias'), 1, 0, 'C', 1);
    $pdf->cell(36, 10, utf8_decode('Vence'), 1, 1, 'C', 1);
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(100, 149, 237);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros ($datatipoproductos) fila por fila ($rowtipoproducto).
    foreach ($datapresentacion as $rowpresentacion) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, utf8_decode('tipo de producto: '.$rowpresentacion['presentacio']), 1, 1, 'C', 1);
        // Se instancia el módelo Productos para procesar los datos.
        $producto = new Productos;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($producto->setPresentacion($rowpresentacion['id_presentacion'])) {
            // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
            if ($dataproducto = $producto->productopresentacion()) {
                // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                foreach ($dataproducto as $rowproducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(60, 10, utf8_decode($rowproducto['nombre_producto']), 1, 0);
                    $pdf->cell(50, 10, $rowproducto['precio_fact'], 1, 0);
                    $pdf->cell(40, 10,$rowproducto['existencias'], 1, 0);
                    $pdf->cell(36, 10,$rowproducto['vence'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, utf8_decode('No hay producto para este cargo'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, utf8_decode('producto incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, utf8_decode('No hay producto para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método footer()
$pdf->output('I', 'producto.pdf');
