<?php
    include '../Libs/header.php';
?>
<?php 
    if(!empty($_GET['iIdProducto'])){
        $iIdProducto=$_GET['iIdProducto'];
        $sql="update productos set bEliminado=0 where iIdProducto=?";
        $cmd= preparar_query($conexion,$sql,[$iIdProducto]);
        if($cmd){
            echo '<script type="text/javascript">alert("Producto Recuperado Correctamente")</script>';
            header("location: index.php");
        }
        else{
            echo "Error: ". $sql . "" . $cmd->error;
        }
    }
?>
<?php
    include '../Libs/footer.php';
?>