<?php
    include "../Libs/header.php";    
?>
<?php
    $sql="select iIdProducto,sCodigo,sNombre,sDescripcion,iStock,iStockMinimo,fPrecio, bEliminado from Productos where bEliminado=0";
    $productos= preparar_select($conexion,$sql);
    $campos=$productos->fetch_fields();
?>
<br>
<div>
    <a href="create.php" class="btn btn-success btn-sm"><i class="far fa-file"></i>Agregar</a>
</div>
<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <?php
            foreach($campos as $campo){
                echo "<th>".substr($campo->name,1)."</th>";
            }
            echo "<th>Acciones</th>";
        ?>
    </thead>
    <tbody>
        <?php
            foreach($productos as $fila){
                echo '<tr>';
                foreach($campos as $campo){
                    echo '<td>'.$fila[$campo->name].'</td>';
                }
                echo '<td><div class="d-flex-row">
                <div class="p-1"><a href="update.php?iIdProducto='.$fila["iIdProducto"].' "class="btn btn-outline-primary btn-sm"><i class="far fa-edit mr-2"></i>Edit</a></div>';
                if($fila["bEliminado"]==0){
                echo '<div class="p-1"><a href="delete.php?iIdProducto='.$fila["iIdProducto"].' "class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt mr-2"></i>Delete</a></div></div>';
                }else{
                    echo '<div class="p-1"><a href="recuperar.php?iIdProducto='.$fila["iIdProducto"].' "class="btn btn-outline-warning btn-sm"><i class="fas fa-trash-restore-alt mr-2"></i>Recover</a></div></div>';
                }
               echo '<div class="p-1"><a href="imagenes.php?iIdProducto='.$fila["iIdProducto"].' "class="btn btn-outline-secondary btn-sm"><i class="far fa-image mr-2"></i>Image</a></div></div></td></tr>';
            }
        ?>
    </tbody>
</table>
</div>
<?php
    include "../Libs/footer.php";    
?>