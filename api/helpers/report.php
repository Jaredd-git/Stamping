<?php
// Se incluye la clase para generar archivos PDF.
require_once('../../libraries/fpdf185/fpdf.php');
require_once('../../entities/dto/usuario.php');

$usuario = new Usuario;
/*
*   Clase para definir las plantillas de los reportes del sitio privado.
*   Para más información http://www.fpdf.org/
*/
class Report extends FPDF
{
    // Constante para definir la ruta de las vistas del sitio privado.
    const CLIENT_URL = 'http://localhost/Stamping/views/dashboard/';
    // Propiedad para guardar el título del reporte.
    private $title = null;

    /*
    *   Método para iniciar el reporte con el encabezado del documento.
    *   Parámetros: $title (título del reporte).
    *   Retorno: ninguno.
    */
    public function startReport($title)
    {
        // Se establece la zona horaria a utilizar durante la ejecución del reporte.
        ini_set('date.timezone', 'America/El_Salvador');
        // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en los reportes.
        session_start();
        // Se verifica si un administrador ha iniciado sesión para generar el documento, de lo contrario se direcciona a la página web principal.
        if (isset($_SESSION['id_admin'])) {
            // Se asigna el título del documento a la propiedad de la clase.
            $this->title = $title;
            $this->setFont('Helvetica', 'B', 12);
            // Se establece el título del documento (true = utf-8).
            $this->setTitle('Administracion - Reporte', true);
            // Se establecen los margenes del documento (izquierdo, superior y derecho).
            $this->setMargins(15, 60, 15);
            // Se añade una nueva página al documento con orientación vertical y formato carta, llamando implícitamente al método header()
            $this->addPage('p', 'letter');
            // Se define un alias para el número total de páginas que se muestra en el pie del documento.
            $this->aliasNbPages();
            $this->setFont('Helvetica', 'B', 12);
        } else {
            header('location:' . self::CLIENT_URL);
        }
    }

    /*
    *   Método para codificar una cadena de alfabeto español a UTF-8.
    *   Parámetros: $string (cadena).
    *   Retorno: cadena convertida.
    */
    public function encodeString($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'utf-8');
    }

    /*
    *   Se sobrescribe el método de la librería para establecer la plantilla del encabezado de los reportes.
    *   Se llama automáticamente en el método addPage()
    */

    public function header()
    {
        // Se establece el logo.
        $this->image('../../images/imagen1.png', 0, -20, 216);
        $this->image('../../images/logo.png', 5, 5, 60);
        $this->setFont('Helvetica', '', 10);
        $this->Text(155, 25, 'Stamping S.A de C.V');
        $this->Text(155, 30, 'El Salvador, San Salvador');
        $this->Text(155, 35, 'Tel. +503 5698 - 2323');
        $this->Text(155, 40, 'Stamping_outlet@gmail.com');
        $this->Text(155, 45, 'http://www.Stamping.com');
        // Se ubica el título.
        $this->setFont('Helvetica', '', 20);
        $this->cell(0, 20, $this->encodeString($this->title), 0, 1, 'C');
        // Se agrega un salto de línea para mostrar el contenido principal del documento.
        $this->ln(2);
    }

    /*
    *   Se sobrescribe el método de la librería para establecer la plantilla del pie de los reportes.
    *   Se llama automáticamente en el método output()
    */
    public function footer()
    {
        // Se establece la posición para el número de página (a 15 milímetros del final).
        $this->setY(-15);
        // Se establece la fuente para el número de página.
        $this->setFont('Helvetica', 'I', 10);
        // Se imprime una celda con el número de página.
        $this->cell(0, 10, $this->encodeString('Página ') . $this->pageNo() . '/{nb}', 0, 0, 'C');
        $this->cell(-30, 10, 'Fecha/Hora: ' . date('d-m-Y H:i:s'), 0, 1, 'C');
        $this->cell(-110, -10, 'Reporte generado por: Ferxxo69');
    }
}