<?php
    include "libs/header.php";
    include "libs/menuBuscar.php";
    include "libs/menuCategoria.php";
?>

<div class="card-deck">
    <div class= "row row-cols-1 row-cols-md-3">
        <?php
            if(!empty($_GET["iIdCategoria"])){
                $iIdCategoria=$_GET["iIdCategoria"];
                $sql="select p.*,i.sNombreArchivo,i.sPath from Productos p inner join Producto_Imagen pi on p.iIdProducto=pi.iIdProducto inner join Imagenes i on pi.iIdImagen=i.iIdImagen inner join Producto_Categoria pc on p.iIdProducto=pc.iIdProducto where pc.iIdCategoria=? and p.bEliminado=0 and i.bEliminado=0 and pi.Es_Principal=1";
                $productos= preparar_select($conexion,$sql,[$iIdCategoria]);
            }else{
                $sql="select p.*,i.sNombreArchivo,i.sPath from Productos p inner join Producto_Imagen pi on p.iIdProducto=pi.iIdProducto inner join Imagenes i on pi.iIdImagen=i.iIdImagen where p.bEliminado=0 and i.bEliminado=0 and pi.Es_Principal=1";
                $productos= preparar_select($conexion,$sql);
            }
            foreach($productos as $producto){

         ?>
            <div class="col mb-3">
                <div class="card h-100">
                    <a href="/CarrodeCompras/VistaProducto/vista.php?iIdProducto=<?php echo $producto["iIdProducto"]; ?>"><img class="card-img-top" src='\CarrodeCompras\Imagenes\<?php echo $producto["sNombreArchivo"]; ?>' alt=" " style="height: 100%;width: 100%;display:block" /></a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $producto["sNombre"]; ?></h5>
                        <p class="card-text"><?php echo $producto["sDescripcion"]; ?></p>
                    </div>
                    <div class="card-footer">
                        <p><?php echo '$'.$producto["fPrecio"]; ?></p>
                        <form method="POST" action="CarroCompras/create.php">
                            <div class="input-group mb-0">
                                <input type="hidden" name="iIdProducto" id="iIdProducto" value="<?php echo $producto["iIdProducto"]; ?>">
                                <input type="hidden" name="fPrecio" id="fPrecio" value="<?php echo $producto["fPrecio"]; ?>">
                                <input type="hidden" name="iStock" id="iStock" value="<?php echo $producto["iStock"]; ?>">
                                <input class="form-control form-control-sm" type="text" min="1"  id="iCantidad" name="iCantidad"/>
                                    <div class="input-group-prepend">
                                            <button class="btn btn-outline-success btn-sm" type="submit" id="iAñadir" name="nAñadir"><i class="fas fa-shopping-cart mr-2"></i>Añadir</button>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }
        ?>
    </div>
</div>
<?php
    include "libs/footer.php";
?>