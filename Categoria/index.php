<?php
    include "../Libs/header.php";    
?>
<?php
    $sql="select iIdCategoria,sNombre, sDescripcion, dFechaAlta, bEliminado from Categorias". ($_SESSION["isAdmin"]==0?"where bEliminado=0": "");
    $categorias= preparar_select($conexion,$sql);
    $campos=$categorias->fetch_fields();
?>
<div>
    <a href="create.php" class="btn btn-success btn-sm"><i class="far fa-file"></i>Agregar Categoria</a>
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
            foreach($categorias as $fila){
                echo '<tr>';
                foreach($campos as $campo){
                    echo '<td>'.$fila[$campo->name].'</td>';
                }
                echo '<td><div class="d-flex-row">
                <div class="p-1"><a href="update.php?iIdCategoria='.$fila["iIdCategoria"].' "class="btn btn-outline-primary btn-sm"><i class="far fa-edit mr-2"></i>Edit</a></div>';
                if($fila["bEliminado"]==0){
                echo '<div class="p-1"><a href="delete.php?iIdCategoria='.$fila["iIdCategoria"].' "class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt mr-2"></i>Delete</a></div></div>';
                }else{
                    echo '<div class="p-1"><a href="recuperar.php?iIdCategoria='.$fila["iIdCategoria"].' "class="btn btn-outline-warning btn-sm"><i class="fas fa-trash-restore-alt mr-2"></i>Recover</a></div></div>';
                }
               echo '<div class="p-1"><a href="productos.php?iIdCategoria='.$fila["iIdCategoria"].' "class="btn btn-outline-secondary btn-sm"><i class="fas fa-file-medical mr-2"></i>Product</a></div></div></td></tr>';
            }
        ?>
    </tbody>
</table>
</div>
<?php
    include "../Libs/footer.php";    
?>