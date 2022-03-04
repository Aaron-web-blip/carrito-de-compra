<?php
      include '../Libs/header.php';
?>
<?php
//simplemente validar los datos del usuario
if(!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['direccion']) && !empty($_POST['provincia']) && !empty($_POST['departamento']) && !empty($_POST['codigo-postal']) && !empty($_POST['metodo_envio']) && !empty($_POST['forma_pago']))
{
    /*$nombre            =   $_POST['nombre'];
    $apellido          =   $_POST['apellido'];
    $provincia         =   $_POST['provincia'];
    $departamento      =   $_POST['departamento'];
    $codigopostal      =   $_POST['codigo-postal'];*/

    $direccion         =   $_POST['direccion'];
    $iIdCarritoCompra  =   $_POST['Carrito'];
    $metodo_envio      =   $_POST['metodo_envio'];    
    $forma_pago        =   $_POST['forma_pago'];
    //validar la forma de pago-consultar si es con tarjeta o efectivo
    if($forma_pago=='Efectivo')
    {
        echo 'Estamos AQUI';
        $numero_de_retiro=rand();
        $formas_de_pago="INSERT INTO formas_pagos (sNombre) values(?)";
        $pago=preparar_query($conexion,$formas_de_pago,[$forma_pago]);
        //luego actualizar el carritoscompras
        if($pago == TRUE)
        {
            echo 'o Aqui';
            $idPago=$pago->insert_id;
            $carritofinal="UPDATE carritoscompras SET Estado='Finalizado', iIdPago=?,iIdMetodoEnvio=? WHERE iIdCarritoCompra=?";
            $finalizado=preparar_query($conexion,$carritofinal,[$idPago,$metodo_envio,$iIdCarritoCompra]);

        }

    }
    //validar los siguientes datos solo si es con tarjeta
    elseif($forma_pago=='Tarjeta')
    {

        if(!empty($_POST['dni']) && !empty($_POST['empresa_tarjeta']) && !empty($_POST['numero_tarjeta']) && !empty($_POST['clave']) && !empty($_POST['fechavto']))
        {
            //echo 'Ahora si';
            /*
            $numero_tarjeta    =   $_POST['numero-tarjeta'];
            $clave_tarjeta     =   $_POST['clave'];
            $fecha             =   $_POST['fechavto']*/
            $cupon=rand(1000,9999);
            $numero_autorizacion=rand();
            $dni               =   $_POST['dni'];
            $empresa_tarjeta   =   $_POST['empresa_tarjeta'];

            $datos_tarjeta="INSERT INTO tarjetas_creditos (NroCupon,NroAutorizacion,iIdEmpresaTarjeta) values(?,?,?)";
            $tarjeta=preparar_query($conexion,$datos_tarjeta,[$cupon,$numero_autorizacion,$empresa_tarjeta]);
            if($tarjeta == TRUE)
            {
                echo 'LLEGO AQUÍ?';
                $iIdTarjetaCredito=$tarjeta->insert_id;
                $formas_de_pago="INSERT INTO formas_pagos (sNombre,iIdTarjetaCredito) values(?,?)";
                $pago=preparar_query($conexion,$formas_de_pago,[$forma_pago,$iIdTarjetaCredito]);

                if($pago == TRUE)
                {
                    $idPago=$pago->insert_id;
                    $carritofinal="UPDATE carritoscompras SET Estado='Finalizado', iIdPago=?,iIdMetodoEnvio=? WHERE iIdCarritoCompra=?";
                    $finalizado=preparar_query($conexion,$carritofinal,[$idPago,$metodo_envio,$iIdCarritoCompra]);

                }
            }
        }else{ echo 'Falta algo'; }
        
    }
?>
<br>
        <div class="card bg-dark text-white">
            <img src="https://eloutput.com/app/uploads-eloutput.com/2020/06/ElOutput-072.jpg" class="card-img" style="width:auto" alt="...">
            <div class="card-img-overlay">
                <div class="text-center">
                    <h1 class="card-title">¡¡¡Felicidades acabas de Finalizar tu compra!!!</h1>
                    <p class="card-text">Tus productos llegaran a esta dirección '<?php echo $direccion; ?>' o podras ir a buscarlo a nuestra sucursal según el metodo de envio que hallas elegido.</p>
                    <?php if($_POST['forma_pago'] =='Efectivo'){ ?>

                        <p class="card-text">A continuación veras tu numero de atenticación para recibir tu producto. Advertencia solo podras verlo una ves asi que será mejor que lo apuntes.</p>
                        <h4 class="card-text"><?php echo $numero_de_retiro?></h4>
                    
                    <?php }elseif($_POST['forma_pago'] == 'Tarjeta'){ ?>

                        <p class="card-text">Usted ha elegido metodo de pago Tarjeta, si elegiste entrega a domicilio el producto puede llegar a entre 1 o 2 semanas, si no podes venir a retirar tu producto en nuestra sucursal.</p>
                    
                    <?php }else{ ?>
                        <p class="card-text"><h4>POR FAVOR COMPLETE LOS CAMPOS FALTANTES!!!</h4></p>
                    <?php } ?>
                    <form action="/CarrodeCompras/PDFNuevo/detalle-completo.php" method="POST">
                        <input type="hidden" name="carrito" value="<?php echo $iIdCarritoCompra; ?>">
                        <input type="hidden" name="pago"  value="<?php echo $forma_pago; ?>">
                        <input type="hidden" name="direccion" value="<?php echo $direccion; ?>">
                        <?php if($_POST['forma_pago'] =='Efectivo'){ ?>
                        <input type="hidden" name="codigo" value="<?php echo $numero_de_retiro; ?>">
                        <?php }elseif($_POST['forma_pago'] == 'Tarjeta'){ ?>
                        <input type="hidden" name="dni" value="<?php echo $dni; ?>">
                        <?php } ?>
                        <input class="btn btn-secondary btn-lg btn-block" type="submit" name="nPdf" id="idPdf" value="Ver en pdf">
                    </form> 
                    <p class="card-text"><h4>¡Muchas Gracias por comprar en nuestro sitio Web!</h4></p>
                    <p><a class="btn btn-secondary btn-lg btn-block" href="/CarrodeCompras/">Sigue navegando en Nuestro sitio Web</a></p>            
                </div>
            </div>
        </div>
<?php     
}

?>

<?php
    include '../Libs/footer.php';
?>