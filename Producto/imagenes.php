<?php
    include '../Libs/header.php';
?>
<?php
    if(!empty($_GET["iIdProducto"])){
        $iIdProducto=$_GET["iIdProducto"];
    }
    else{
    if(empty($_POST["nAgregar"])){
        $sNombreArchivo=$_FILES["fileimage"]["name"];
        $sTipoExtension=$_FILES["fileimage"]["type"];
        $iIdProducto=$_POST["iIdProducto"];
        $iOrden=$_POST["txtiOrden"];
        
        $sPath=$_SERVER["DOCUMENT_ROOT"]."/CarrodeCompras/Imagenes";

        move_uploaded_file($_FILES["fileimage"]["tmp_name"],$sPath.'/'.$sNombreArchivo);

        $sql= "insert into Imagenes(sNombreArchivo,sTipoExtension,sPath,bEliminado) values(?,?,?,0)";
        $cmd=preparar_query($conexion, $sql, [$sNombreArchivo,$sTipoExtension,$sPath]);

        if($cmd){
            $iIdImagen=$cmd->insert_id;
            $sql= "insert into Producto_Imagen(iIdProducto,iIdImagen,iOrden,bEliminado) values(?,?,?,0)";
            $cmd=preparar_query($conexion, $sql, [$iIdProducto,$iIdImagen,$iOrden]);
            $mje="Imagen agregada Correctamente";
            header("location: imagenes.php?iIdProducto=$iIdProducto");
        }
        else{
            $mje="Error: ". $sql ." ".$cmd->error;
        }
    }
}
    $sql="select * from Producto_Imagen pi inner join Imagenes i on pi.iIdImagen=i.iIdImagen where i.bEliminado=0 and iIdProducto=?";
    $imagenes= preparar_select($conexion,$sql,[$iIdProducto]);
?>
<?php 
        if(!empty($mje)){
            echo "<p>".$mje."</p>";
        }
?>
<div>Agregar una Imagen<a href="/CarrodeCompras/Producto/">(Volver a la lista de Producto)</a></div>
<form id="imageform" class="form-horizontal" action="imagenes.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="iIdProducto" id="iIdProducto" value="<?php echo $iIdProducto;?>" >
<div class="form-group row">
    <label for="fileimage" class="col-1">Imagen: </label>
        <div class="col-10">
            <input type="file" class="col" row="5" name="fileimage" id="fileimage" />
        </div>
</div>
<div class="form-group row">
    <label for="txtiOrden" class="col-1">Orden: </label>
        <div class="col-10">
            <input type="number" row="5" class="col-2" name="txtiOrden" id="txtiOrden" />
        </div>
</div>
<div class="form-group row">
<button type="submit" name="nAgregar" id="iAgregar" class="btn btn-outline-primary">Agregar Imagen</button>
</div>
</form>
<form id="imagePrincipal" class="form-horizontal" action="iprincipal.php" method="POST">
<div class="table-responsive">
<table class="table table-striped">
    <thead>
    <th>Seleccion</th>
    <th>Imagen</th>
    <th>Nombre</th>
    <th>Orden</th>
    <th>Acciones</th>
    </thead>
    <tbody>
            <?php
                if($imagenes->num_rows>0){
                    foreach($imagenes as $imagen){
                        echo '<tr><td><input type="radio" name="imgPrincipal" id="myCheck"  value="'.$imagen["iIdImagen"].'"></td>
                        <input type="hidden" name="iIdProducto" id="iIdProducto" value="'.$imagen["iIdProducto"].'">
                        <td><img src="/CarrodeCompras/Imagenes/'.$imagen["sNombreArchivo"].'" alt="" width="32px" height="32px"></td>
                        <td>'.$imagen["sNombreArchivo"].'</td>
                        <td>'.$imagen["iOrden"].'</td>
                        <td><a href="../Producto_Imagen/delete.php?iIdProducto_Imagen='.$imagen["iIdProducto_Imagen"].'&iIdImagen='.$imagen["iIdImagen"].'&iIdProducto='.$imagen["iIdProducto"].'" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt mr-2"></i>Delet</td><tr>';
                        
                    }
                }
            ?>
    </tbody>
</table>
</div>
<input class="btn btn-outline-primary" name="nPrincipal" id="iPrincipal" type="submit" value="Seleccionar">
</form>
<?php
    include '../Libs/footer.php';
?>