<?php
    include '../Libs/header.php';
?>
<?php
    if(!empty($_GET['iIdProducto'])){
        $iIdProductoActual=$_GET['iIdProducto'];
        $sql="select * from productos where iIdProducto=?";
        $datos= preparar_select($conexion,$sql,[$iIdProductoActual]);
        if($datos->num_rows>0){
            $fila = $datos->fetch_assoc();
        }
        else{
            echo "Error: ". $sql . "" . $cmd->error;
        }
    }
    else{
        if(!empty($_POST)){
            $iIdProducto=$_POST['iIdProducto'];
            $sCodigo=$_POST['txtsCodigo'];
            $sNombre=$conexion->real_escape_string($_POST['txtsNombre']);
            $sDescripcion= $conexion->real_escape_string($_POST['sDescripcion']);
            $fPrecio=$_POST['txtfPrecio'];
            $iStock=$_POST['txtiStock'];
            $iStockMinimo=$_POST['txtiStockMinimo'];
            $sql= "update productos set sCodigo=?,sNombre=?,sDescripcion=?,fPrecio=?,iStock=?,iStockMinimo=?,dFecha=now() where iIdProducto=?";
            $cmd= preparar_query($conexion,$sql,[$sCodigo,$sNombre,$sDescripcion,$fPrecio,$iStock,$iStockMinimo,$iIdProducto]);
            if($cmd){
                echo '<script type="text/javascript">alert("Producto Modificado Correctamente")</script>';
            }
            else{
                $mje="Error: ". $sql . "" . $cmd->error;
            }
        }
    }
?>
<div>Modificar Producto <a href="index.php">(Volver a la lista de Producto)</a></div>
    <form id="createform" class="form-horizontal" role="form" action="update.php" method="POST" autocomplete="off">
        <input type="hidden" name="iIdProducto" id="iIdProducto" value=<?php echo $iIdProductoActual; ?>>
        <div class="form-group row">
            <label for="txtsCodigo" class="col-2">Codigo</label>
            <div class="col-2">
                <input type="text" class="form-control form-control-sm" name="txtsCodigo" id="txtsCodigo" value=<?php echo $fila["sCodigo"]; ?>>
            </div>
        </div>
        <div class="form-group row">
            <label for="txtsNombre" class="col-2">Nombre</label>
            <div class="col-2">
                <input type="text" class="form-control form-control-sm"  name="txtsNombre" id="txtsNombre" value="<?php echo htmlspecialchars($fila["sNombre"]); ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="sDescripcion" class="col-2">Descripcion</label>
            <div class="col-10">
                <textarea rows="5" class="form-control form-control-sm" cols="200" name="sDescripcion" id="sDescripcion"><?php echo htmlspecialchars($fila["sDescripcion"]); ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="txtfPrecio" class="col-2">Precio</label>
            <div class="col-2">
                <input type="text" class="form-control form-control-sm" name="txtfPrecio" id="txtfPrecio" value=<?php echo $fila["fPrecio"]; ?>>
            </div>
        </div>
        <div class="form-group row">
            <label for="txtiStock" class="col-2">Stock</label>
            <div class="col-2">
                <input type="text" class="form-control form-control-sm" name="txtiStock" id="txtiStock" value=<?php echo $fila["iStock"]; ?>>
            </div>
        </div>
        <div class="form-group row">
            <label for="txtiStockMinimo" class="col-2">Stock Minimo</label>
            <div class="col-2">
                <input type="text" class="form-control form-control-sm" name="txtiStockMinimo" id="txtiStockMinimo" value=<?php echo $fila["iStockMinimo"]; ?>>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Grabar</button>
        </div>
    </form>
<?php
    include '../Libs/footer.php';
?>