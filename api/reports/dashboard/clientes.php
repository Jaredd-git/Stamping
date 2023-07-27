<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/cliente.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Clientes por estado');
// Se instancia el módelo Categoría para obtener los datos.
$cliente = new Cliente;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataClientes = $cliente->readAll()) {
    // Se establece un color de relleno para los encabezados.

    $pdf->setFillColor(147, 203, 230);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 12);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(78, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(78, 10, 'Apellido', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(255);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', 'B', 10);

    foreach ($dataClientes as $rowClientes) {
        ($rowClientes['estado_cliente']) ? $estado = 'Activo' : $estado = 'Inactivo';
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(78, 10, $pdf->encodeString($rowClientes['nombre_cliente']), 1, 0, 'C', 1);
        $pdf->cell(78, 10, $pdf->encodeString($rowClientes['apellido_cliente']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, $estado, 1, 1, 'C', 1);}
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('Producto incorrecta o inexistente'), 1, 1);
    } 
    $pdf->output('I', 'Clientes.pdf');