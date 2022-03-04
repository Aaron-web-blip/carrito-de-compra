<?php
    session_start();
    include '../Libs/header.php';
?>
<?php 
    if(!empty($_GET['iIdProducto_Imagen'])){
        $iIdProducto_Imagen=$_GET['iIdProducto_Imagen'];
        $iIdImagen=$_GET["iIdImagen"];
        $iIdProducto=$_GET["iIdProducto"];
        $sql="delete from producto_imagen where iIdProducto_Imagen=?";
        $cmd= preparar_query($conexion,$sql,[$iIdProducto_Imagen]);
        if($cmd){
            $sql="delete from imagenes where iIdImagen=?";
            $cmd=preparar_query($conexion,$sql,[$iIdImagen]);
        }
        else{
            echo "Error: ". $sql . " " . $cmd->error;
        }
        header("location: ../Producto/Imagenes.php?iIdProducto=$iIdProducto");
    }
?>
<?php
    include '../Libs/footer.php';
?>