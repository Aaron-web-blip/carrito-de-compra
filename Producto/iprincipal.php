<?php
    include '../Libs/header.php';
?>
<?php
    if(isset($_POST["nPrincipal"])){
        $iIdImagen=$_POST["imgPrincipal"];
        $iIdProducto=$_POST["iIdProducto"];

        $sql='UPDATE producto_imagen SET Es_Principal=0 WHERE iIdProducto=?';
        $cmd= preparar_query($conexion,$sql,[$iIdProducto]);
        if($cmd){
            $sql='UPDATE producto_imagen SET Es_Principal=1 WHERE iIdImagen=?';
            $cmd= preparar_query($conexion,$sql,[$iIdImagen]);
            header("location: imagenes.php?iIdProducto=$iIdProducto");
        }
    }
?>
<?php
    include '../Libs/footer.php';
?>