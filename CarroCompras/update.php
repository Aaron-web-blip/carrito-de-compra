<?php
      session_start();
      include "../Libs/conexion.php";
      include "../Libs/funciones.php";
?>
<?php

  if(!empty($_POST["datos"])){
      $dato=explode(",",$_POST["datos"]);

      $iCantidadNueva   =$dato[0];
      $iIdProducto      =$dato[1];
      $iIdCarritoCompra =$dato[2];
      $iStock           =$dato[3];
      $iCantidadActual  =$dato[4];
      $NuevaCantidad=0;
      //Si el stock es mayor a la cantidad y la cantidad es mayor a 0 prosigue.
      if($iCantidadNueva<=$iStock && $iCantidadNueva>0)
      {
        //echo "Sigue la comparación<br>";

        //Si la cantidad Nueva es mayor a la actual se resta en el stock
        if($iCantidadActual<$iCantidadNueva)
        {
          //echo "Actualiza la cantidad Suma<br>";
          //$NuevaCantidad=$iCantidadNueva-$iCantidadActual;
          $sql="UPDATE det_carrito SET iCantidad=iCantidad+? WHERE iIdProducto=? AND iIdCarritoCompra=?";
          $cmd=preparar_query($conexion,$sql,[$iCantidadNueva-$iCantidadActual,$iIdProducto,$iIdCarritoCompra]);

            //Una ves realizado el cambio se calcula el total y se actualiza
            if($cmd == TRUE)
            {
              //echo "Hace y guarda la suma en total<br>";
              $sql='SELECT SUM(fPrecio*iCantidad) as Total FROM det_carrito WHERE iIdCarritoCompra=?';
              $totalrecuperado=preparar_select($conexion,$sql,[$iIdCarritoCompra]);
              foreach($totalrecuperado as $total)
              {
                $datos= $total['Total'];
              }
              $sql="UPDATE carritoscompras SET Total=? WHERE iIdCarritoCompra=?";
              $Total=preparar_query($conexion,$sql,[$datos,$iIdCarritoCompra]);

              //Al final se quitara lla cantidad en el stcok principal de producto
              if($Total == TRUE)
              {
                //echo "Se termina el proceso restando en stock principal<br>";
                $sql="UPDATE productos SET iStock=iStock-? WHERE iIdProducto=?";
                $cmd=preparar_query($conexion,$sql,[$iCantidadNueva-$iCantidadActual,$iIdProducto]);
                
                if($cmd == TRUE)
                {
                  $total="SELECT Total FROM carritoscompras WHERE iIdCarritoCompra=?";
                  $consulta=preparar_select($conexion,$total,[$iIdCarritoCompra]);
                  foreach($consulta as $total)
                  {
                    $dato= $total['Total'];
                  }
                  echo $dato;
                }
              }
            }
        }
        //Si la cantidad Nueva es menor a la actual se aumenta en el stock
        elseif($iCantidadNueva<$iCantidadActual)
        {
          //echo "Actualiza la cantidad solo la cambia<br>";
          //$NuevaCantidad=$iCantidadActual-$iCantidadNueva;
          $sql="UPDATE det_carrito SET iCantidad=? WHERE iIdProducto=? AND iIdCarritoCompra=?";
          $cmd=preparar_query($conexion,$sql,[$iCantidadNueva,$iIdProducto,$iIdCarritoCompra]);

            //Una ves realizado el cambio se calcula el total y se actualiza
            if($cmd == TRUE)
            {
              //echo "Hace y guarda la suma en total<br>";
              $sql='SELECT SUM(fPrecio*iCantidad) as Total FROM det_carrito WHERE iIdCarritoCompra=?';
              $totalrecuperado=preparar_select($conexion,$sql,[$iIdCarritoCompra]);
              foreach($totalrecuperado as $total)
              {
                $datos= $total['Total'];
              }
              $sql="UPDATE carritoscompras SET Total=? WHERE iIdCarritoCompra=?";
              $Total=preparar_query($conexion,$sql,[$datos,$iIdCarritoCompra]);

              //Al final se quitara lla cantidad en el stcok principal de producto
              if($Total == TRUE)
              {
               //echo "Se termina el proceso restando en stock principal<br>";
                $sql="UPDATE productos SET iStock=iStock+? WHERE iIdProducto=?";
                $cmd=preparar_query($conexion,$sql,[$iCantidadActual-$iCantidadNueva,$iIdProducto]);
                
                if($cmd == TRUE)
                {
                  $sql="SELECT Total FROM carritoscompras WHERE iIdCarritoCompra=?";
                  $consulta=preparar_select($conexion,$sql,[$iIdCarritoCompra]);
                  foreach($consulta as $total)
                  {
                    $dato= $total['Total'];
                  }
                  echo $dato;
                }

              }
            }
        }
      }
      else
      {
        echo "Aqui un mensaje (El producto no posee demasiado stock)";
      }
  }else{
      echo "Error: ". $sql . "" . $cmd->error;
        }


    

?>