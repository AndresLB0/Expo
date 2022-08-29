<?php
// Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
if (isset($_GET['id'])) {
    require('../helpers/dashboard_report.php');
    require('../modelos/institucion.php');
    require('../modelos/clientes.php');

    // Se instancia el módelo marca para procesar los datos.
    $institucion = new institucion;

    // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
    if ($institucion->setId($_GET['id'])) {
        // Se verifica si la categoría del parametro existe, de lo contrario se direcciona a la página web de origen.
        if ($rowinstitucion = $institucion->readOne()) {
            // Se instancia la clase para crear el reporte.
            $pdf = new Report;
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('cliente tipo ' . $rowinstitucion['tipo_insti']);
            // Se instancia el módelo cliente para procesar los datos.
            $cliente = new clientes;
            if ($cliente->setInsti($rowinstitucion['id_insti'])) {
                // Se verifica si existen registros (cliente) para mostrar, de lo contrario se imprime un mensaje.
                if ($datacliente = $cliente->clienteinstitucion()) {
                    // Se establece un color de relleno para los encabezados.
                    $pdf->setFillColor(80, 80, 200);
                    // Se establece la fuente para los encabezados.
                    $pdf->setFont('Times', 'B', 11);
                    // Se imprimen las celdas con los encabezados.
                    $pdf->cell(40, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
                    $pdf->cell(100, 10, utf8_decode('Nombre del contacto'), 1, 0, 'C', 1);
                    $pdf->cell(40, 10, utf8_decode('horario'), 1, 1, 'C', 1);
                    // Se establece la fuente para los datos de los cliente.
                    $pdf->setFont('Times', '', 11);
                    // Se recorren los registros ($datacliente) fila por fila ($rowcliente).
                    foreach ($datacliente as $rowcliente) {
                        // Se imprimen las celdas con los datos de los cliente.
                        $pdf->cell(40, 10, utf8_decode($rowcliente['nombre']), 1, 0);
                        $pdf->cell(100, 10, $rowcliente['nombre_cont'], 1, 0);
                        $pdf->cell(40, 10, $rowcliente['horario'], 1, 1);
                    }
                } else {
                    $pdf->cell(0, 10, utf8_decode('No hay cliente para esta categoría'), 1, 1);
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
