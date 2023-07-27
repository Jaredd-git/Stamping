<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/producto.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Existencias de productos');
// Se instancia el módelo Categoría para obtener los datos.
$producto = new Producto;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProductos = $producto->readAll()) {
    // Se establece un color de relleno para los encabezados.

    $pdf->setFillColor(43, 110, 181);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 12);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Precio', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Existencias', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(255);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', 'B', 10);

    foreach ($dataProductos as $rowProducto) {
        ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(40, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0, 'C', 1);
        $pdf->cell(30, 10, $estado, 1, 0, 'C', 1);
        $pdf->cell(30, 10, $rowProducto['existencias'], 1, 1, 'C', 1);}
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('Producto incorrecta o inexistente'), 1, 1);
    } 
    $pdf->output('I', 'Existencias.pdf');