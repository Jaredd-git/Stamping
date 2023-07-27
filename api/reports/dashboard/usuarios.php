<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/usuario.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Usuarios');
// Se instancia el módelo Categoría para obtener los datos.
$usuario = new Usuario;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataUsuario = $usuario->readAll()) {
    // Se establece un color de relleno para los encabezados.

    $pdf->setFillColor(147, 203, 230);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 12);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(53, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(53, 10, 'Apellido', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Correo electronico', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Alias', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(255);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', '', 8);

    foreach ($dataUsuario as $rowUsuario) {
        $pdf->cell(53, 10, $pdf->encodeString($rowUsuario['nombre_usuario']), 1, 0, 'C', 1);
        $pdf->cell(53, 10, $pdf->encodeString($rowUsuario['apellido_usuario']), 1, 0, 'C', 1);
        $pdf->cell(50, 10, $pdf->encodeString($rowUsuario['correo_usuario']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, $pdf->encodeString($rowUsuario['alias_usuario']), 1, 1, 'C', 1);}
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('Usuario incorrecto o inexistente'), 1, 1);
    } 
    $pdf->output('I', 'Usuarios.pdf');