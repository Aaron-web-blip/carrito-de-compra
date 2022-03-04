<?php
    require("../FPDF/fpdf.php");
    
    class MiPdf extends FPDF
    {
        function Header()
        {
            $this->Ln(15);
            $this->Image('https://seeklogo.com/images/P/playstation-logo-A5B6E4856C-seeklogo.com.png', 175, 5, 30);
            $this->SetFont('Arial', 'BU', 16);
            $this->Cell(30);
            $this->Cell(120, 10, 'Detalle de Compra', 0, 0, 'C');
            $this->Ln(20);
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página') .' '. $this->PageNo().'/ {nb}', 0, 0, 'C');
        }
    }

?>