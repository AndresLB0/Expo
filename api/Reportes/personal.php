<?php
require('../helpers/dashboard_report.php');
require('../modelos/personal.php');
require('../modelos/cargos.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Personal de la empresa');

// Se instancia el módelo Categorías para obtener los datos.
$cargos = new cargos;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($datacargos = $cargos->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(80, 80, 200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(126, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
    $pdf->cell(30, 10, utf8_decode('Usuario'), 1, 0, 'C', 1);
    $pdf->cell(30, 10, utf8_decode('telefono'), 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(100, 149, 237);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros ($datatipoproductos) fila por fila ($rowtipoproducto).
    foreach ($datacargos as $rowcargos) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, utf8_decode('tipo de producto: '.$rowcargos['nombre_cargo']), 1, 1, 'C', 1);
        // Se instancia el módelo Productos para procesar los datos.
        $personal = new personal;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($personal->setCargo($rowcargos['id_cargo'])) {
            // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
            if ($datapersonal = $personal->personalcargo()) {
                // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                foreach ($datapersonal as $rowpersonal) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, utf8_decode($rowpersonal['nombre']), 1, 0);
                    $pdf->cell(30, 10, $rowpersonal['usuario'], 1, 0);
                    $pdf->cell(30, 10,$rowpersonal['telefono'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, utf8_decode('No hay personal para este cargo'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, utf8_decode('personal incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, utf8_decode('No hay personal para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método footer()
$pdf->output('I', 'personal.pdf');
