
<?php
// Desactivar la salida del búfer
ob_start();

// Configurar cabeceras para JSON
header('Content-Type: application/json');

// Manejar errores
function handleError($errno, $errstr, $errfile, $errline) {
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => "Error: $errstr"]);
    exit();
}
set_error_handler('handleError');

try {
    require('fpdf.php');

    class PDF extends FPDF
    {
        // ... (mantén el código de la clase PDF igual)
        function Header()
        {
            $this->SetFont('Arial', 'B', 20);
            $this->SetFillColor(52, 152, 219); // Color de fondo azul
            $this->SetTextColor(255);
            $this->Cell(0, 30, 'Formulario de Contacto', 0, 1, 'C', true);
            $this->Ln(10);
        }
    
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(128);
            $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    // Verificar si se recibieron datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Crear nuevo PDF
        $pdf = new PDF();
        $pdf->AddPage();

        // Establecer fuente
        $pdf->SetFont('Arial', '', 12);

        // Datos del formulario
        $nombre = $_POST['name'] ?? 'N/A';
        $email = $_POST['email'] ?? 'N/A';
        $mensaje = $_POST['message'] ?? 'N/A';

        // Agregar contenido
        // ... (mantén el código para agregar contenido igual)
        $pdf->SetFillColor(240, 240, 240); // Color de fondo gris claro
        $pdf->SetTextColor(0);
        
        $pdf->Cell(50, 10, 'Nombre:', 1, 0, 'L', true);
        $pdf->Cell(0, 10, $nombre, 1, 1);
        
        $pdf->Cell(50, 10, 'Email:', 1, 0, 'L', true);
        $pdf->Cell(0, 10, $email, 1, 1);
        
        $pdf->Cell(50, 10, 'Mensaje:', 1, 0, 'L', true);
        $pdf->MultiCell(0, 10, $mensaje, 1);
        // Generar PDF
        $pdfFilename = 'formulario_contacto_' . time() . '.pdf';
        $pdfPath = __DIR__ . '/' . $pdfFilename;
        $pdf->Output($pdfPath, 'F');

        // Verificar si el archivo se creó correctamente
        if (file_exists($pdfPath)) {
            // Devolver la URL del PDF
            $pdfUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $pdfFilename;
            echo json_encode(['success' => true, 'pdfUrl' => $pdfUrl]);
        } else {
            throw new Exception('Error al generar el PDF');
        }
    } else {
        throw new Exception('Método no permitido');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// Limpiar y enviar la salida
ob_end_flush();