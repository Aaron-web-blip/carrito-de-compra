<?php
    include '../Libs/header.php';
?>
<?php 
    if(!empty($_GET['iIdCategoria'])){
        $iIdCategoria=$_GET['iIdCategoria'];
        $sql="update Categorias set bEliminado=0 where iIdCategoria=?";
        $cmd= preparar_query($conexion,$sql,[$iIdCategoria]);
        if($cmd){
            echo '<script type="text/javascript">alert("Categoria Recuperado Correctamente")</script>';
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