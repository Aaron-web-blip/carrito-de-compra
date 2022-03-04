<?php
    include "../libs/header.php";
?>
<?php
$mje="";
if(isset($_POST["nAñadir"]) || isset($_POST["nAceptar"]) ){

    if(empty($_SESSION["iIdUsuario"]))
    {
        header("location: /CarrodeCompras/Acceso/login.php");
    }
    else{

        $iIdUsuario=$_SESSION["iIdUsuario"];        
        $iIdProducto=$_POST["iIdProducto"];
        $iCantidad=$_POST["iCantidad"];
        $fPrecio=$_POST["fPrecio"];
        $iStock=$_POST["iStock"];

        $sql="SELECT iIdCarritoCompra,iIdUsuario FROM carritoscompras WHERE iIdUsuario=? and upper(Estado)=upper('Curso')";
        $carro=preparar_select($conexion,$sql,[$iIdUsuario]);
            foreach($carro as $carrito){
                $iIdCarritoCompra=$carrito["iIdCarritoCompra"]; 
            }

            if($carro->num_rows>0)
            {
                echo '<h1>Hola si hay un carrito</h1>';

                $sql="SELECT de.iIdProducto FROM carritoscompras cc inner join det_carrito de INNER JOIN productos p on cc.iIdCarritoCompra=de.iIdCarritoCompra AND de.iIdProducto=p.iIdProducto WHERE de.iIdProducto=? and cc.iIdCarritoCompra=? and p.bEliminado=0 and upper(cc.Estado)= upper('Curso')";
                $producto=preparar_select($conexion,$sql,[$iIdProducto,$iIdCarritoCompra]);

                if($producto->num_rows>0){

                    header("location: /CarrodeCompras/CarroCompras/");
                    //echo '<h1>Hola el Producto ya fue seleccionado</h1>';
                    
                }
                //Desde Aqui deberia empezar a hacer control de Stcok
                else
                {

                    //echo '<h1>Hola el Producto no fue seleccionado</h1>';
                    //Se controla que la cantidad no sea mayor al stcok en productos
                    if($iCantidad<=$iStock && $iCantidad>0)
                    {
                        $sql="Insert Into det_carrito(iIdProducto,iCantidad,fPrecio,iIdCarritoCompra) values(?,?,?,?)";
                        $cmd=preparar_query($conexion,$sql,[$iIdProducto,$iCantidad,$fPrecio,$iIdCarritoCompra]);

                        //Hace y guarda la suma en total
                        if($cmd)
                        {
                            $sqluno="SELECT SUM(fPrecio*iCantidad) as Total FROM carritoscompras cc INNER JOIN det_carrito de ON cc.iIdCarritoCompra=de.iIdCarritoCompra WHERE cc.iIdCarritoCompra=? AND upper(cc.Estado)= upper('Curso')";
                            $Sumas=preparar_select($conexion,$sqluno,[$iIdCarritoCompra]);
              
                            foreach($Sumas as $Suma){
                              $total=$Suma["Total"];
                            }
              
                            $sqldos="UPDATE carritoscompras cc SET cc.Total=? WHERE cc.iIdCarritoCompra=? AND upper(cc.Estado)= upper('Curso')";
                            $Total=preparar_query($conexion,$sqldos,[$total,$iIdCarritoCompra]);

                            if($Total)
                            {
                                //echo "Se termina el proceso restando en stock principal<br>";
                                $sql="UPDATE productos SET iStock=iStock-? WHERE iIdProducto=?";
                                $cmd=preparar_query($conexion,$sql,[$iCantidad,$iIdProducto]);

                                    if(isset($_POST["nAñadir"])){
                                        header("location: /CarrodeCompras/");
                                    }elseif (isset($_POST["nAceptar"])) {
                                        header("location: /CarrodeCompras/VistaProducto/vista.php?iIdProducto=$iIdProducto");
                                    }
                            }
                        }
                    }
                    else
                    {
                        //No hay suficiente stock
                    }

                }
                
            }
            else
            {
                //echo '<h1>Hola no hay un carrito</h1>';

                $sql="INSERT INTO carritoscompras(iIdUsuario) values(?)";
                $cmd=preparar_query($conexion, $sql, [$iIdUsuario]);
                    //desde aqui se empesaria a realizar un control de stock
                    if($cmd == TRUE)
                    {
                        $iIdCarritoCompra=$cmd->insert_id;
                        //Se controla que la cantidad no sea mayor al stcok en productos
                        if($iCantidad<=$iStock && $iCantidad>0)
                        {
                            $sql="Insert Into det_carrito(iIdProducto,iCantidad,fPrecio,iIdCarritoCompra) values(?,?,?,?)";
                            $cmd=preparar_query($conexion,$sql,[$iIdProducto,$iCantidad,$fPrecio,$iIdCarritoCompra]);
                            //Hace y guarda la suma en total
                            if($cmd)
                            {
                                $sqluno="SELECT SUM(fPrecio*iCantidad) as Total FROM carritoscompras cc INNER JOIN det_carrito de ON cc.iIdCarritoCompra=de.iIdCarritoCompra WHERE cc.iIdCarritoCompra=? AND upper(cc.Estado)= upper('Curso')";
                                $Sumas=preparar_select($conexion,$sqluno,[$iIdCarritoCompra]);
                  
                                foreach($Sumas as $Suma){
                                  $total=$Suma["Total"];
                                }
                  
                                $sqldos="UPDATE carritoscompras cc SET cc.Total=? WHERE cc.iIdCarritoCompra=? AND upper(cc.Estado)= upper('Curso')";
                                $Total=preparar_query($conexion,$sqldos,[$total,$iIdCarritoCompra]);

                                if($Total)
                                {
                                    //echo "Se termina el proceso restando en stock principal<br>";
                                    $sql="UPDATE productos SET iStock=iStock-? WHERE iIdProducto=?";
                                    $cmd=preparar_query($conexion,$sql,[$iCantidad,$iIdProducto]);

                                    if(isset($_POST["nAñadir"])){
                                        header("location: /CarrodeCompras/");
                                    }elseif (isset($_POST["nAceptar"])) {
                                        header("location: /CarrodeCompras/VistaProducto/vista.php?iIdProducto=$iIdProducto");
                                    }
                                }
                            }
                            
                        }
                        else
                        {
                            //No hay suficiente stock
                        }

                    }
            }
        }
    }
    else
    {
        $msj="Error: ". $sql ." ".$datos->error;
    }
?>
<?php
    include "../libs/footer.php";
?>