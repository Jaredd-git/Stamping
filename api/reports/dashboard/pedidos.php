<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/pedido.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Pedidos');
// Se instancia el módelo Categoría para obtener los datos.
$pedido = new Pedido;

if ($dataPedidos = $pedido->readAllPedidosE()) {
    // Se establece un color de relleno para los encabezados.

    $pdf->setFillColor(43, 110, 181);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 12);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, 'Cliente', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Fecha', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Direccion', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(255);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', 'B', 10);

    foreach ($dataPedidos as $rowPedido) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(40, 10, $pdf->encodeString($rowPedido['cliente']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, $pdf->encodeString($rowPedido['fecha_pedido']), 1, 0, 'C', 1);
        $pdf->cell(45, 10, $pdf->encodeString($rowPedido['direccion_pedido']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, ($rowPedido['estado']), 1, 1, 'C', 1);}
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('Pedido incorrecta o inexistente'), 1, 1);
    }

if ($dataPedidos = $pedido->readAllPedidosC()) {
    // Se establece un color de relleno para los encabezados.

    $pdf->setFillColor(43, 110, 181);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 12);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, 'Cliente', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Fecha', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Direccion', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(255);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', 'B', 10);

    foreach ($dataPedidos as $rowPedido) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(40, 10, $pdf->encodeString($rowPedido['cliente']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, $pdf->encodeString($rowPedido['fecha_pedido']), 1, 0, 'C', 1);
        $pdf->cell(45, 10, $pdf->encodeString($rowPedido['direccion_pedido']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, ($rowPedido['estado']), 1, 1, 'C', 1);}
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('Pedido incorrecta o inexistente'), 1, 1);
    }

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedidos = $pedido->readAllPedidosP()) {
    // Se establece un color de relleno para los encabezados.

    $pdf->setFillColor(43, 110, 181);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 12);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, 'Cliente', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Fecha', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Direccion', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(255);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', 'B', 10);

    foreach ($dataPedidos as $rowPedido) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(40, 10, $pdf->encodeString($rowPedido['cliente']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, $pdf->encodeString($rowPedido['fecha_pedido']), 1, 0, 'C', 1);
        $pdf->cell(45, 10, $pdf->encodeString($rowPedido['direccion_pedido']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, ($rowPedido['estado']), 1, 1, 'C', 1);}
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('Pedido incorrecta o inexistente'), 1, 1);
    } 

    $pdf->output('I', 'Pedidos.pdf');