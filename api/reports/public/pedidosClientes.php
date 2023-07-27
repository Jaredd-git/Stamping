<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/reportPublic.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/detallepedido.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Existencias');
// Se instancia el módelo Categoría para obtener los datos.
$detallePedido = new Detalle;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataDetalle = $detallePedido->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 14);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(80, 10, 'N° Pedido', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Producto', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Talla', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Cantidad', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Precio', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Arial', 'B', 12);

    foreach ($dataDetalle as $rowDetalle) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(80, 10, $pdf->encodeString($rowDetalle['id_pedido']), 1, 0);
        $pdf->cell(30, 10, $rowDetalle['id_producto'], 1, 0);
        $pdf->cell(30, 10, $rowDetalle['id_talla'], 1, 0);
        $pdf->cell(30, 10, $rowDetalle['cantidad_producto'], 1, 0);
        $pdf->cell(30, 10, $rowDetalle['precio'], 1, 1);
    }
    } 