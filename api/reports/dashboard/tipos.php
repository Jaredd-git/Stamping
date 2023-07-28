<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/producto.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Tipos de productos');
// Se instancia el módelo Categoría para obtener los datos.
$producto = new Producto;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProductos = $producto->readAll()) {
    // Se establece un color de relleno para los encabezados.

    $pdf->setFillColor(147, 203, 230);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 12);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(60, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(80, 10, 'Descripcion', 1, 0, 'C', 1);
    $pdf->cell(46, 10, 'Tipo', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(255);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', '', 10);

    foreach ($dataProductos as $rowProducto) {
        ($rowProducto['id_tipo']) ? $estado = 'Camisa' : $estado = 'Sueter';
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(60, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0, 'C', 1);
        $pdf->cell(80, 10, $rowProducto['descripcion_producto'], 1, 0, 'C', 1);
        $pdf->cell(46, 10, $estado, 1, 1, 'C', 1);}
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('Producto incorrecta o inexistente'), 1, 1);
    } 
    $pdf->output('I', 'Existencias.pdf');