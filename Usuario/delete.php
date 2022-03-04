<?php
    include '../Libs/header.php';
?>
<?php 
    if(!empty($_GET['iIdUsuario'])){
        echo $iIdUsuario=$_GET['iIdUsuario'];
        $sql="UPDATE `usuarios` SET `bEliminado` = '1' WHERE `usuarios`.`iIdUsuario` =?";
        $cmd= preparar_query($conexion,$sql,[$iIdUsuario]);
        if($cmd){
            echo '<script type="text/javascript">alert("Producto Eliminado Correctamente")</script>';
            
            header("location: ../Acceso/logout.php");
        }
        else{
            echo "Error: ". $sql . "" . $cmd->error;
        }
    }
?>
<?php
    include '../Libs/footer.php';
?>