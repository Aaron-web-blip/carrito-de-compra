<?php
      session_start();
      include "../Libs/conexion.php";
      include "../Libs/funciones.php";
?>
<?php     
    if (isset($_POST["nPdf"]))
            {
                
                date_default_timezone_set("America/Argentina/Buenos_Aires"); 
                $fecha=date("d/m/Y h:i a");
                require("plantillaPDF.php");

                $pdf = new MiPdf();
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetFont('Arial','B', 10);
                $pdf->SetFillColor(255,255,255);
                $pdf->Cell(30, 6, utf8_decode('Cliente'), 0, 0, 'C', 100);
                $pdf->SetFont('Arial','', 10);
                $pdf->Cell(65, 6, utf8_decode($_SESSION["sApellido"].' '.$_SESSION["sNombre"]), 0, 0, 'C', 100);
                $pdf->SetFont('Arial','B', 10);
                $pdf->Cell(30, 6, utf8_decode('DNI'), 0, 0, 'C', 100);
                $pdf->SetFont('Arial','', 10);
                if($_POST['pago'] == 'Tarjeta'){
                $pdf->Cell(65, 6, utf8_decode($_POST["dni"]), 0, 1, 'C', 100);
                }elseif($_POST['pago']=='Efectivo'){
                $pdf->Cell(65, 6, utf8_decode($_SESSION["iDNI"]), 0, 1, 'C', 100);
                }
                $pdf->SetFont('Arial','B', 10);
                $pdf->Cell(30, 6, utf8_decode('Domicilio'), 0, 0, 'C', 100);
                $pdf->SetFont('Arial','', 10);
                $pdf->Cell(65, 6, utf8_decode($_POST["direccion"]), 0, 0, 'C', 100);
                $pdf->SetFont('Arial','B', 10);
                $pdf->Cell(30, 6, utf8_decode('Email'), 0, 0, 'C', 100);
                $pdf->SetFont('Arial','', 10);
                $pdf->Cell(65, 6, utf8_decode($_SESSION["sEmail"]), 0, 1, 'C', 100);

                $pdf->ln();
                $pdf->SetFont('Arial','B', 10);
                $pdf->SetFillColor(255,255,255);
                $pdf->Cell(40, 6, utf8_decode('Fecha de Emisión'), 0, 0, 'C', 100);
                $pdf->SetFont('Arial','', 10);
                $pdf->Cell(40, 6, $fecha, 0, 1, 'C', 100);

                $pdf->SetFont('Arial','B', 12);
                $pdf->SetFillColor(255,255,255);
                $pdf->Ln(10);
                $pdf->Cell(20, 6, utf8_decode('Código'), 0, 0, 'C', 100);
                $pdf->Cell(70, 6, utf8_decode('Descripción'), 0, 0, 'C', 100);
                $pdf->Cell(30, 6, 'Cantidad', 0, 0, 'C', 100);
                $pdf->Cell(35, 6, 'Precio', 0, 0, 'C', 100);
                $pdf->Cell(35, 6, 'Sub Total', 0, 1, 'C', 100);
                $carrito=$_POST['carrito'];
                $sql = "SELECT cc.Total, dc.iCantidad, dc.fPrecio,p.sCodigo,p.sNombre FROM carritoscompras cc INNER JOIN det_carrito dc INNER JOIN productos p ON cc.iIdCarritoCompra=dc.iIdCarritoCompra AND dc.iIdProducto=p.iIdProducto WHERE dc.iIdCarritoCompra=? ORDER BY p.sNombre";
                $queryArticulos = preparar_select($conexion,$sql,[$carrito]);
                if ($queryArticulos->num_rows > 0)
                {            
                    $datos = $queryArticulos->fetch_assoc();       
                    $pdf->SetFont('Arial','', 10);
                    $pdf->SetFillColor(255,255,255);
                    foreach($queryArticulos as $fila)
                    {
                        $pdf->Cell(20, 6, $fila["sCodigo"], 0, 0, 'C', 1);
                        $pdf->Cell(70, 6, $fila["sNombre"], 0, 0, 'C', 1);
                        $pdf->Cell(30, 6, $fila["iCantidad"], 0, 0, 'C', 1);
                        $pdf->Cell(35, 6, '$ '.$fila["fPrecio"], 0, 0, 'C', 1);
                        $pdf->Cell(35, 6, '$ '.$fila["iCantidad"]*$fila["fPrecio"], 0, 1, 'C', 1);
                    }
                    $pdf->SetFont('Arial','B', 10);
                    $pdf->Cell(155, 6, 'Total', 0, 0, 'C', 1);
                    $pdf->Cell(35, 6, '$ '.$datos["Total"], 0, 1, 'C', 1);
                    $pdf->ln();
                    if($_POST['pago']=='Efectivo')
                    {
                        $pdf->SetFont('Arial','B', 10);
                        $pdf->Cell(95, 6, utf8_decode('Código de Retiro'), 1, 0, 'C', 1);
                        $pdf->Cell(95, 6, $_POST['codigo'], 1, 1, 'C', 1);
                    }
                    $pdf->Output('', 'articulos_completo.pdf');
                }            
                else
                    echo "No se encontraron artículos para mostrar.";  
            }
?>