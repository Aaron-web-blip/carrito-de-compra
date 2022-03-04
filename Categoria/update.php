<?php
    include '../Libs/header.php';
?>
<?php
    if(!empty($_GET['iIdCategoria'])){
        $iIdCategoriaActual=$_GET['iIdCategoria'];
        $sql="select * from Categorias where iIdCategoria=?";
        $datos= preparar_select($conexion,$sql,[$iIdCategoriaActual]);
        if($datos->num_rows>0){
            $fila = $datos->fetch_assoc();
        }
        else{
            echo "Error: ". $sql . "" . $cmd->error;
        }
    }
    else{
        if(!empty($_POST)){
            $iIdCategoria=$_POST['iIdCategoria'];
            $sCodigo=$_POST['txtsCodigo'];
            $sNombre=$conexion->real_escape_string($_POST['sNombre']);
            $sDescripcion= $conexion->real_escape_string($_POST['sDescripcion']);
            $sql= "update Categorias set sNombre=?,sDescripcion=? where iIdCategoria=?";
            $cmd= preparar_query($conexion,$sql,[$sNombre,$sDescripcion,$iIdCategoria]);
            if($cmd){
                echo '<script type="text/javascript">alert("Categoria Agregado Correctamente")</script>';
                header("location: index.php");
            }
            else{
                $mje="Error: ". $sql . "" . $cmd->error;
            }
        }
    }
?>
<div>Modificar Categoria <a href="index.php">(Volver a la lista de Categoria)</a></div>
    <form id="createform" class="form-horizontal" role="form" action="update.php" method="POST" autocomplete="off">
        <input type="hidden" name="iIdCategoria" id="iIdCategoria" value=<?php echo $iIdCategoriaActual; ?>>
        <div class="form-group row">
            <label for="sNombre" class="col-2">Nombre</label>
            <div class="col-2">
                <input type="text" class="form-control form-control-sm"  name="sNombre" id="sNombre" value=<?php echo htmlspecialchars($fila["sNombre"]); ?>>
            </div>
        </div>
        <div class="form-group row">
            <label for="sDescripcion" class="col-2">Descripcion</label>
            <div class="col-10">
                <textarea row="4" class="form-control form-control-sm" cols="100" name="sDescripcion" id="sDescripcion"><?php echo htmlspecialchars($fila["sDescripcion"]); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Grabar</button>
        </div>
    </form>
<?php
    include '../Libs/footer.php';
?>