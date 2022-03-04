<?php
    include '../Libs/header.php';
?>

<?php
    if(isset($_POST['nPagar']))
    {
       $iIdCarritoCompra=$_POST['nCarro'];
       $iIdUsuario=$_SESSION['iIdUsuario'];
    


?>
<br>
  <div class="row">
    <div class="col-sm">
            <h2>Tu Resumen</h2>
            <?php
                $datos="SELECT cc.*,dc.iCantidad,p.fPrecio,p.sNombre FROM carritoscompras cc INNER JOIN det_carrito dc INNER JOIN productos p ON cc.iIdCarritoCompra=dc.iIdCarritoCompra AND dc.iIdProducto=p.iIdProducto WHERE upper(cc.Estado)=upper('CURSO') AND cc.iIdUsuario=? AND dc.iIdCarritoCompra=?";
                $resumenes=preparar_select($conexion,$datos,[$iIdUsuario,$iIdCarritoCompra]);
            //tabla de resumen
            ?>
            <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Producto</th>
                        <th class="text-center" scope="col">Cant</th>
                        <th class="text-center" scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($resumenes as $resumen){ ?>
                        <tr>
                            <td><?php echo $resumen['sNombre']; ?></td>
                            <td class="text-center"><?php echo $resumen['iCantidad']; ?></td>
                            <td class="text-center">$ <?php echo $resumen['fPrecio']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th class="text-center" scope="col" colspan="2">Total</th>
                        <td class="text-center" colspan="1">$ <?php echo $resumen['Total']; ?></td>
                    </tr>
                    </tbody>
                </table>




      
    </div>
    <!--Formulario para datos Personales -->
    <div class="col-sm">
        <h2>1. Datos Personales</h2>
            <form method="POST" action="pagofinalizado.php">
            <input type="hidden" name="Carrito" value="<?php echo $iIdCarritoCompra; ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="Nombre">Nombre</label>
                        <input type="text" class="form-control" id="Nombre" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="Apellido">Apellido</label>
                        <input type="text" class="form-control" id="Apellido" name="apellido" placeholder="Apellido" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Dirección">Dirección</label>
                    <input type="text" class="form-control" id="Dirección" name="direccion" placeholder="Dirección" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                    <label for="Provincia">Provincia</label>
                        <input type="text" class="form-control" id="Provincia" name="provincia" placeholder="Provincia" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="Departamento">Departamento</label>
                        <input type="text" class="form-control" id="Departamento" name="departamento" placeholder="Departamento" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                    <label for="Codigo">Codigo Postal</label>
                        <input type="text" class="form-control" id="Codigo" name="codigo-postal" placeholder="xxxx" required> 
                    </div>
                </div>

    </div>
    <!-- Medio de pago -->
    <div class="col-sm">
        <h2>2. Medio de Pago</h2>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputState">Forma de Envio</label>
                            <select id="inputState" name="metodo_envio" class="form-control">
                            <option value="">Seleccione...</option>
                            <?php 
                                $sql="SELECT * FROM metodos_envios WHERE Estado=1";
                                $metodos=preparar_select($conexion,$sql);
                                foreach($metodos as $metodo)
                                {
                            ?>
                                <option name="metodo" value="<?php echo $metodo['iIdMetodoEnvio']; ?>"><?php echo $metodo['sDescripcion']; ?></option>
                                
                            <?php } ?>
                            </select>
                    </div>
                </div>



                <!-- forma de pago -->

                <p>

                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="forma_pago" class="custom-control-input" value="Efectivo" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                    <label class="custom-control-label" for="customRadioInline1">Efectivo</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="forma_pago" class="custom-control-input" value="Tarjeta" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">
                    <label class="custom-control-label" for="customRadioInline2">Tarjeta</label>
                    </div>

                </p>
                
                    <div class="row">
                    <div class="col-md-12">
                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            Si seleccionas efectivo, no debes brindar más información.
                        </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <!--<div class="card card-body">-->
        
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <label for="DNI">DNI del Titular </label>
                                    <input type="text" class="form-control" id="DNI" name="dni" placeholder="xxxxxxxx">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="empresa_tarjeta">Tipo de Tarjeta</label>
                                    <select id="inputState" name="empresa_tarjeta" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php 
                                            $sql="SELECT * FROM empresas_tarjetas";
                                            $tarjetas=preparar_select($conexion,$sql);
                                            foreach($tarjetas as $tarjeta)
                                            {
                                        ?>
                                            <option value="<?php echo $tarjeta['iIdEmpresaTarjeta']; ?>"><?php echo $tarjeta['sNombre']; ?></option>
                                            
                                        <?php } ?>
                                        </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                <label for="numero_tarjeta">Numero de Tarjeta </label>
                                    <input type="number" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="xxxxxxxxxxxxxxxx">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                <label for="clave">Clave</label>
                                    <input type="number" class="form-control" id="clave" name="clave" placeholder="xxxx">
                                </div>
                                <div class="form-group col-md-8">
                                <label for="fechavto">Valida Hasta</label>
                                    <input type="text" class="form-control" id="fechavto" name="fechavto" placeholder="xx-xx">
                                </div>
                            </div>

            </div>
            </div>
        </div>
    <!--</div>-->


    </div>
  </div>
</div>
    <div class="alert alert-info col-md-12" role="alert">
        <input type="hidden" name="nCarro" id="iCarro" value="<?php echo $producto['iIdCarritoCompra']; ?>">
        <div class="p-1"><button name="nPagar" id="iPagar" class="btn btn-success btn-lg btn-block"><i class="fas fa-money-check-alt mr-2"></i>Finalizar</a></button></div>
    </div>
</form>
<?php } ?>
<?php
    include '../Libs/footer.php';
?>