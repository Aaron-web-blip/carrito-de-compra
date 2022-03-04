<?php
    include '../Libs/header.php';
?>
<?php 
    if(isset($_POST["nBorrar"])){
        $iIdCarritoCompra=$_POST['Carrito'];
        $iIdProducto     =$_POST['Producto'];
        $iCantidad       =$_POST['Cantidad'];

        $sql="DELETE FROM det_carrito WHERE iIdProducto=? AND iIdCarritoCompra=?";
        $cmd= preparar_query($conexion,$sql,[$iIdProducto,$iIdCarritoCompra]);

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
                $sql="UPDATE productos SET iStock=iStock+? WHERE iIdProducto=?";
                $cmd=preparar_query($conexion,$sql,[$iCantidad,$iIdProducto]);
                header("location: index.php");
            }
        }
        /*if($cmd){
            header("location: carro.php");
        }*/
        else{
            echo "Error: ". $sql . "" . $cmd->error;
        }
    }
?>
<?php
    include '../Libs/footer.php';
?>