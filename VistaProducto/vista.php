<?php
    include "../libs/header.php";
    include "../libs/menuBuscar.php";
?>
<a href="/CarrodeCompras/" class="btn btn-dark btn-lg rounded-circle"><i class="fas fa-arrow-circle-left size:3px"></i></a><br>
<?php
    if(!empty($_GET["iIdProducto"])){
        $iIdProducto=$_GET["iIdProducto"];
        $sql="SELECT p.*,i.* FROM productos p inner join producto_imagen pi inner join imagenes i on p.iIdProducto=pi.iIdProducto and pi.iIdImagen=i.iIdImagen where i.bEliminado=0 and p.bEliminado=0 and p.iIdProducto=?";
        $productos= preparar_select($conexion,$sql,[$iIdProducto]);
    }
    ?>
<br>

<div class="row">

    <div class="col-md-12 row">

      <div class="col-md-6">

        <div class="row">

          <div class="col-md-12">

            <div id="imgPrincipal" class="carousel slide" data-ride="carousel">

              <div class="carousel-inner">

                <?php
                  $cont=0;
                  foreach ($productos as $producto){
                ?>

                  <div class="carousel-item <?php echo $cont == 0 ? "active" :""; ?> ">
                    <img src='\CarrodeCompras\Imagenes\<?php echo $producto["sNombreArchivo"]; ?>' class="d-block w-100" style="height: 500px;width: 500px;display:block" alt="...">
                  </div>

                  <?php $cont++; ?>

                  <?php } $cont; ?>
                
              </div>

              <a class="carousel-control-prev" href="#imgPrincipal" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#imgPrincipal" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>

            </div>
            
          </div>
          
        </div>
        
      </div>

      <div class="card text-white bg-dark mb" style="max-width: 50%;">
          <div class="card-header"><h2><?php echo $producto["sNombre"]; ?></h2></div>
          <div class="card-body">
            <div class="card-title">Descripción </div>
              <p class="card-text"><?php echo $producto["sDescripcion"]; ?></p>
            <div class="card-title">Precio: $<?php echo $producto["fPrecio"]; ?></div>
            <div class="card-title">Stock: <?php echo $producto["iStock"]; ?><br><small class="text-muted">SKU#: <?php echo $producto["sCodigo"]; ?></small></div>
            <div class="card-footer">
              <form method="POST" action="../CarroCompras/create.php">
                  <div class="input-group mb-0">
                    <input type="hidden" name="iIdProducto" id="iIdProducto" value="<?php echo $producto["iIdProducto"]; ?>">
                    <input type="hidden" name="fPrecio" id="fPrecio" value="<?php echo $producto["fPrecio"]; ?>">
                    <input class="form-control form-control-sm" type="text" min="1"  id="iCantidad" name="iCantidad"/>
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-success btn-sm" type="submit" id="iAceptar" name="nAceptar"><i class="fas fa-shopping-cart mr-2"></i>Añadir</button>        
                        </div>
                  </div>
              </form>
            </div> 
         
          </div>

        </div>

  </div>
</div>
<?php
    include "../libs/footer.php";
?>