<?php
    include "../Libs/header.php";    
?>
<?php
    if(!empty($_GET["iIdCategoria"])){
        $iIdCategoria=$_GET["iIdCategoria"];
    }else{
        if(!empty($_POST)){
            $iIdCategoria=$_POST['iIdCategoria'];
            $sql='insert into Producto_Categoria(iIdCategoria,iIdProducto) values(?,?)';
            foreach($_POST['ids'] as $iid){
                $cmd= preparar_query($conexion,$sql,[$iIdCategoria,$iid]);
                $mje="Agregado a categoria Correctamente";
            }
        }
    }
    $sql="select iIdProducto,sNombre,sDescripcion,fPrecio, bEliminado from Productos where bEliminado=0";
    $productos= preparar_select($conexion,$sql);
    $campos=$productos->fetch_fields();
?>
<?php 
        if(!empty($mje)){
            echo "<p>".$mje."</p>";
        }
    ?>
Agregar un producto a una categoria<a href="/CarrodeCompras/Categoria/">(Volver a Categorias)</a>
<form id="productosform" class="form-horizontal" action="productos.php" method="POST">
<input type="hidden" name="iIdCategoria" value="<?php echo $iIdCategoria; ?>">
<div class="table-responsive">
<table class="table table-striped">
    <thead>
    <th>Seleccion</th>
        <?php
            foreach($campos as $campo){
                echo "<th>".substr($campo->name,1)."</th>";
            }
        ?>
    </thead>
    <tbody>
        <?php
            foreach($productos as $fila){
                echo '<tr>';
                echo '<td><input type="checkbox" name="ids[]" value="'.$fila["iIdProducto"].'"></td>';
                foreach($campos as $campo){
                    echo '<td>'.$fila[$campo->name].'</td>';
                }
                echo '</tr>';
            }
        ?>
    </tbody>
</table>
<input class="btn btn-outline-primary" type="submit" value="Guardar">
</div>
</form>
<?php
    include "../Libs/footer.php";    
?>