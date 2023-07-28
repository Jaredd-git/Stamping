<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/reportPublic.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/pedido.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Mis pedidos');
// Se instancia el módelo Categoría para obtener los datos.
$pedido = new Pedido;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedido = $pedido->readAllP()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(147, 203, 230);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 12);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(20, 10, '#', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Cliente', 1, 0, 'C', 1);
    $pdf->cell(20, 10, 'Estado', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Fecha', 1, 0, 'C', 1);
    $pdf->cell(46, 10, 'Direccion', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(255);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', '', 10);
    // Se cargan los datos a la tabla anteriormente creada
    foreach ($dataPedido as $rowPedido) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(20, 10, $pdf->encodeString($rowPedido['id_pedido']), 1, 0, 'C', 1);
        $pdf->cell(60, 10, $pdf->encodeString($rowPedido['cliente']), 1, 0, 'C', 1);
        $pdf->cell(20, 10, $rowPedido['estado'], 1, 0, 'C', 1);
        $pdf->cell(40, 10, $rowPedido['fecha_pedido'], 1, 0, 'C', 1);
        $pdf->cell(46, 10, $rowPedido['direccion_pedido'], 1, 1, 'C', 1);
    }
    }else {
        $pdf->cell(0, 10, $pdf->encodeString('Cliente incorrecto o inexistente'), 1, 1);
    } 
    $pdf->output('I', 'Pedidos.pdf');