<?php
require_once('../../helpers/report.php');
require_once('../../entities/dto/producto.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Productos por existencias');
$producto = new Producto;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProductos = $producto->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->SetFillColor(140, 178, 200);
    $pdf->SetTextColor(255);
    $pdf->SetFont('Arial','B');
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(80, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(20, 10, 'Precio', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Existencias', 1, 1, 'C', 1);
    foreach ($dataProductos as $rowProducto) {
        ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(80, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
        $pdf->cell(20, 10, $rowProducto['precio_producto'], 1, 0);
        $pdf->cell(30, 10, $estado, 1, 0);
        $pdf->cell(30, 10, $rowProducto['existencias'], 1, 1);}
    }else {
        $pdf->cell(0, 10, $pdf->encodeString('Categoría incorrecta o inexistente'), 1, 1);
    }
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
