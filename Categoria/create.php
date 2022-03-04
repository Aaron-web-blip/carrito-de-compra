<?php
    include '../Libs/header.php';
?>
<?php
    $mje="";
    if(!empty($_POST)){
        $sNombre=$_POST["txtNombre"];
        $sDescripcion=$_POST["txtDescripcion"];

        $sql="Insert into categorias(sNombre,sDescripcion,bEliminado) values(?,?,0)";
        $datos=preparar_query($conexion,$sql,[$sNombre,$sDescripcion]);
        if($datos){
            $mje="Categoria agregada correctamente";
        }else{
            $mje="Error: ". $sql ." ".$datos->error;
        }
    }
    ?>
    <?php 
        if(!empty($mje)){
            echo "<p>".$mje."</p>";
        }
    ?>
    Cargar Producto <a href="index.php">(Volver a la página de productos)</a>
    <form id="loginform" action="create.php" method="POST">
    <div class="form-group row"> 
        <label for="txtNombre" class="col-2">Nombre</label>
            <div class="col-4">
                <input type="text" class="form-control form-control-sm" name="txtNombre" id="txtNombre" />
            </div>
    </div>
    <div class="form-group row"> 
        <label for="txtDescripcion" class="col-2">Descripcion</label>
            <div class="col-10">
                <textarea name="txtDescripcion" class="form-control form-control-sm" id="txtDescripcion" rows="5" cols="100" ></textarea>
            </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Subir Categoria</button>
    </div>
     </form>  
<?php
    include '../Libs/footer.php';
?>