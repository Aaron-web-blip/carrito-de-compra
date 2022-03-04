<?php
    include '../Libs/header.php';
?>
<?php
    $mje="";
    if(!empty($_POST)){
        $sCodigo=$_POST["txtCodigo"];
        $sNombre=$_POST["txtNombre"];
        $sDescripcion=$_POST["txtDescripcion"];
        $iStock=$_POST["txtStock"];
        $fPrecio=$_POST["txtPrecio"];
        $iStockMinimo=$_POST['txtiStockMinimo'];

        $sql="Insert into productos(sCodigo,sNombre,sDescripcion,iStock,fPrecio,iStockMinimo) values(?,?,?,?,?,?)";
        $datos=preparar_query($conexion,$sql,[$sCodigo,$sNombre,$sDescripcion,$iStock,$fPrecio,$iStockMinimo]);
        if($datos){
            $mje="Registro agregado correctamente";
        }else{
            $mje="Error: ". $sql ." ".$datos->error;
        }
    }
    ?>
    <body>
    <?php 
        if(!empty($mje)){
            echo "<p>".$mje."</p>";
        }
    ?>
    Cargar Producto <a href="index.php">(Volver a la página de productos)</a>
    <form class="form-horizontal" role="form" id="loginform" action="create.php" method="POST">
        <div class="form-group row"> 
            <label for="txtCodigo" class="col-2">Codigo: </label>
                <div class="col-2">
                    <input type="text" name="txtCodigo" id="txtCodigo" />
                </div>
        </div>
        <div class="form-group row">
            <label for="txtNombre" class="col-2">Nombre: </label>
                <div class="col-2">
                    <input type="text" name="txtNombre" id="txtNombre" />
                </div>
        </div>
        <div class="form-group row">
            <label for="txtDescripcion" class="col-2">Descripcion: </label>
                <div class="col-10">
                    <textarea name="txtDescripcion" id="txtDescripcion" rows="5" cols="100" ></textarea>
                </div>
        </div>
        <div class="form-group row">
            <label for="txtStock" class="col-2">Stock: </label>
                <div class="col-2">
                    <input type="number" name="txtStock" id="txtStock" />
                </div>
        </div>
        <div class="form-group row">
            <label for="txtPrecio" class="col-2">Precio: </label>
                <div class="col-2">
                    <input type="number" step="any" name="txtPrecio" id="txtPrecio" />
                </div>
        </div>
        <div class="form-group row">
            <label for="txtiStockMinimo" class="col-2">Stock Minimo: </label>
            <div class="col-2">
                <input type="number" name="txtiStockMinimo" id="txtiStockMinimo" />
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="btnAceptar" class="btn btn-outline-primary">Aceptar</button>
        </div>
    </form>  
<?php
    include '../Libs/footer.php';
?>