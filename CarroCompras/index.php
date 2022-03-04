<?php
    include '../Libs/header.php';
?>
<br>
<?php
  if(!empty($_SESSION["iIdUsuario"]))
  {
    $iIdUsuario=$_SESSION["iIdUsuario"];

    $sql="SELECT iIdCarritoCompra,iIdUsuario FROM carritoscompras WHERE iIdUsuario=? and upper(Estado)=upper('Curso')";
    $carro=preparar_select($conexion,$sql,[$iIdUsuario]);

    if($carro->num_rows>0){
?>


<div class="table-responsive-xl ">
<table class="table table-bordered table-striped table-dark">
<thead class="thead-dark">
  <tr class="text-center">
    <th scope="col">Producto</th>
    <th scope="col">Nombre</th>
    <th scope="col">Descripción</th>
    <th scope="col">Precio</th>
    <th scope="col">Cantidad</th>
    <th scope="col">SubTotal</th>
    <th scope="col">Acción</th>
  </tr>
</thead>
<tbody>
<?php
    $sql="SELECT cc.*, dc.*,p.sNombre,p.sDescripcion, p.iStock, i.sNombreArchivo FROM carritoscompras cc INNER JOIN det_carrito dc INNER JOIN productos p INNER JOIN producto_imagen pi INNER JOIN imagenes i on cc.iIdCarritoCompra=dc.iIdCarritoCompra and dc.iIdProducto=p.iIdProducto AND pi.iIdProducto=p.iIdProducto AND pi.iIdImagen=i.iIdImagen WHERE pi.Es_Principal=1 and cc.Estado='CURSO' AND cc.iIdUsuario=?";
    $productos=preparar_select($conexion,$sql,[$iIdUsuario]);
    $total=0;
    foreach($productos as $producto){

?>
    
    <tr>
        <input type="hidden" name="iIdProductonCantidad<?php echo $producto['iIdProducto']; ?>" id="iIdProductonCantidad<?php echo $producto['iIdProducto']; ?>" value="<?php echo $producto['iIdProducto']; ?>">
        <input type="hidden" name="iIdCarritoCompra" id="iIdCarritoCompra" value="<?php echo $producto['iIdCarritoCompra']; ?>">
        <input type="hidden" name="iStocknCantidad<?php echo $producto['iIdProducto']; ?>" id="iStocknCantidad<?php echo $producto['iIdProducto']; ?>" value="<?php echo $producto['iStock']; ?>">
        <input type="hidden" name="cantnCantidad<?php echo $producto['iIdProducto']; ?>" id="cantnCantidad<?php echo $producto['iIdProducto']; ?>" value="<?php echo $producto['iCantidad']; ?>">
          

        <td><img src='\CarrodeCompras\Imagenes\<?php echo $producto["sNombreArchivo"]; ?>' style="height: 100px;width: 100px;display:block" class="img-thumbnail" alt="Responsive image"></td>
        <td><?php echo $producto["sNombre"]; ?></td>
        <td><?php echo $producto["sDescripcion"]; ?></td>
        <td>
            <div id="iPrecionCantidad<?php echo $producto['iIdProducto']; ?>"><?php echo $producto["fPrecio"]; ?></div>
        </td>
        <td>
            <input type="text" style="height: auto;width: 50px;" id="iCantidad<?php echo $producto['iIdProducto']; ?>" name="nCantidad<?php echo $producto['iIdProducto']; ?>" value="<?php echo $producto['iCantidad']; ?>" onblur="CalcularPrecioXCantidad(this);">
        </td>
        <td>
            <div id="iResultadonCantidad<?php echo $producto['iIdProducto']; ?>"><?php echo $producto["fPrecio"] * $producto['iCantidad']; ?></div>
        </td>
        <td>
            <form action="delete.php" method="POST">
              <input type="hidden" name="Producto" id="Producto" value="<?php echo $producto['iIdProducto']; ?>">
              <input type="hidden" name="Carrito" id="Carrito" value="<?php echo $producto['iIdCarritoCompra']; ?>">
              <input type="hidden" name="Cantidad" id="Cantidad" value="<?php echo $producto['iCantidad']; ?>">
              <div class="p-1"><button name="nBorrar" id="iBorrar" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt mr-2"></i>Eliminar</a></button></div>
            </form>
        </td>
    </tr>
    
      <?php $total=$producto["Total"]; ?>

  <?php
    } ?>
  
    <tr>
      <th class="text-center" scope="row" colspan="5">TOTAL: </th>
      <th class="text-center" scope="row" colspan="2"><div id='totalactualizado'><?php echo $total; ?></div></th>
    </tr>
  </tbody>
</table>
</div>
<form action="pagar.php" method="POST">
  <div class="alert alert-info" role="alert">
    <input type="hidden" name="nCarro" id="iCarro" value="<?php echo $producto['iIdCarritoCompra']; ?>">
    <div class="p-1"><button name="nPagar" id="iPagar" class="btn btn-success btn-lg btn-block"><i class="fas fa-money-check-alt mr-2"></i>Ir a Pagar</a></button></div>
  </div>
</form>

<?php }else { ?>


  <div class="card bg-dark text-white">
    <img src="https://eloutput.com/app/uploads-eloutput.com/2020/06/ElOutput-072.jpg" class="card-img" alt="...">
    <div class="card-img-overlay">
      <div class="text-center">
        <h1 class="card-title">Nota</h1>
        <p class="card-text">Hola aquí se mostrara el detalle de su carrito de compras, pero por el momento no has agregado ningun producto al carrito. Que estas esperando empieza a ver nuestros productos, para empezar a realizar tus compras no pierdas más tiempo y ve a nuestra Pagina Principal.</p>
        <p class="card-text"><h4>PlayStations 1,2,3 ...</h4></p>
        <p class="card-text"><h4>Juegos</h4></p>
        <p class="card-text"><h4>Articulos para Consolas</h4></p>
        <p class="card-text"><h4>Y MÁS ....</h4></p>
        <p class="card-text"><h4>Muchas Gracias por elegir nuestro sitio web!!! </h4></p>
        <a class="btn btn-secondary btn-lg btn-block" href="/CarrodeCompras/">Inicio</a>
        <div class="card-footer">
        </div>
      </div>
    </div>
  </div>


<?php } }?>
    <script>
        function CalcularPrecioXCantidad(cantidad){
            if (cantidad.value != '') {
              if(parseInt(cantidad.value) > 0){
                var stock = parseInt(document.getElementById("iStock" + cantidad.name).value);
                var cant  = parseInt(cantidad.value);
                if(stock>=cant)
                {
                  
                  var cantidadactual = parseInt(document.getElementById("cant" + cantidad.name).value);
                  var producto       = parseInt(document.getElementById("iIdProducto" + cantidad.name).value);
                  var CarritoCompra  = parseInt(document.getElementById("iIdCarritoCompra").value);

                  let datos = [cant,producto,CarritoCompra,stock,cantidadactual];

                  var msj =  document.getElementById("msj");
                  console.log(datos);
                  
                  var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                      if (this.readyState == 4 || this.status == 200) {
                        document.getElementById("iResultado" + cantidad.name).innerHTML = cantidad.value * parseFloat(document.getElementById("iPrecio" + cantidad.name).innerHTML);
                        document.getElementById("totalactualizado").innerHTML = this.responseText;
                      }
                    };
                    xmlhttp.open("POST", "update.php", true);
                    xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                    xmlhttp.send('datos=' + datos);
                    //location.reload();
                }
                else
                {
                  document.getElementById("iResultado" + cantidad.name).innerHTML = 'Stock Insuficiente';
                  console.log(stock + cant);
                }
              }
              else{
                document.getElementById("iResultado" + cantidad.name).innerHTML = 'De 1+ en Adelante';
              }
                }
            else
            {
                document.getElementById("iResultado" + cantidad.name).innerHTML = 'Ingrese un Valor';
            }            
          }       
    </script>

<?php
    include '../Libs/footer.php';
?>