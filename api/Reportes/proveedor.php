<?php
// Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
if (isset($_GET['id'])) {
    require('../helpers/dashboard_report.php');
    require('../modelos/Proveedores.php');
    require('../modelos/productos.php');

    // Se instancia el módelo marca para procesar los datos.
    $proveedor = new proveedor;

    // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
    if ($proveedor->setId($_GET['id'])) {
        // Se verifica si la categoría del parametro existe, de lo contrario se direcciona a la página web de origen.
        if ($rowproveedor = $proveedor->readOne()) {
            // Se instancia la clase para crear el reporte.
            $pdf = new Report;
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de '.$rowproveedor['nombre']);
            // Se instancia el módelo Productos para procesar los datos.
            $producto = new Productos;
            if ($producto->setProvee($rowproveedor['id_provee'])) {
                // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
                if ($dataProductos = $producto->productosproveedor()) {
                    // Se establece un color de relleno para los encabezados.
                    $pdf->setFillColor(80, 80, 200);
                    // Se establece la fuente para los encabezados.
                    $pdf->setFont('Times', 'B', 11);
                    // Se imprimen las celdas con los encabezados.
                    $pdf->cell(126, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
                    $pdf->cell(30, 10, utf8_decode('tipo'), 1, 0, 'C', 1);
                    $pdf->cell(30, 10, utf8_decode('linea'), 1, 1, 'C', 1);
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                        // Se imprime una celda con el nombre de la categoría.
                    // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                    foreach ($dataProductos as $rowProducto) {
                        // Se imprimen las celdas con los datos de los productos.
                        $pdf->cell(126, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0);
                        $pdf->cell(30, 10, $rowProducto['presentacio'], 1, 0);
                        $pdf->cell(30, 10,$rowProducto['nombre_linea'], 1, 1);   
                    }
              
            }else {
                    $pdf->cell(0, 10, utf8_decode('No hay productos para esta categoría'), 1, 1);
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
?>