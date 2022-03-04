<?php
    include '../Libs/header.php';
?>
<?php

    if(!empty($_GET['iIdUsuario'])){
        $iIdUsuario=$_GET['iIdUsuario'];
        $sql="SELECT * FROM usuarios WHERE iIdUsuario=?";
        $datos= preparar_select($conexion,$sql,[$iIdUsuario]);
        if($datos->num_rows>0){
            $fila = $datos->fetch_assoc();
        }
        else{
            echo "Error: ". $sql . "" . $cmd->error;
        }
    }
    else{
        if(empty($_POST["nCambiar"])){
            $iIdUsuario=$_POST["iIdUsuario"];
            $sLogin=$_POST["sLogin"];
            $sClave=$_POST["sClave"];
            $sNombre=$_POST["sNombre"];
            $sApellido=$_POST["sApellido"];
            $iDNI=$_POST["iDNI"];
            $sDomicilio=$_POST["sDomicilio"];
            $sEmail=$_POST["sEmail"];
            $msj="";

            $sql= "update usuarios set sLogin=?, sClave=?, sNombre=?, sApellido=?, sEmail=?, sDomicilio=?, iDNI=?  where iIdUsuario=?";
            $cmd= preparar_query($conexion,$sql,[$sLogin,$sClave,$sNombre,$sApellido,$sEmail,$sDomicilio,$iDNI,$iIdUsuario]);
            if($cmd){
                $msj="Registro Actualizado";
                header("location: update.php?iIdUsuario=$iIdUsuario");
            }
            else{
                $mje="Error: ". $sql . "" . $cmd->error;
            }
        }
    }
?>
<?php
    if(isset($msj)){
        echo '<div class="alert alert-success">';
        echo $msj;
        echo '<a href="index.php" calss="badge badge-success">Ver Perfil</a>'; 
        echo '</div>';
    }
?>
<br>
<form id="createform" class="form-horizontal" role="form" action="update.php" method="POST" >
    <input type="hidden" name="iIdUsuario" id="iIdUsuario" value=<?php echo $fila["iIdUsuario"]; ?>>

        <div class="card mb-3" style="width: auto;">
            <div class="card-header">Editar Usuario <a href="/CarrodeCompras/Usuario/">(Volver al Perfil)</a></div>
            <div class="row no-gutters">
                <div class="col-sm">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $fila["sNombre"]." ".$fila["sApellido"]; ?></h2>
                        <div class="card-text">
                                <div class="form-group row">
                                    <label for="sLogin" class="col-4">Username</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm" name="sLogin" id="sLogin" value="<?php echo $fila["sLogin"]; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sClave" class="col-4">Clave</label>
                                    <div class="col-12">
                                        <input type="password" class="form-control form-control-sm" name="sClave" id="sClave" value=<?php echo $fila["sClave"]; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sNombre" class="col-4">Nombre</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm" name="sNombre" id="sNombre" value="<?php echo $fila["sNombre"]; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sApellido" class="col-4">Apellido</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm" name="sApellido" id="sApellido" value="<?php echo $fila["sApellido"]; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="iDNI" class="col-4">DNI</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm" name="iDNI" id="iDNI" value=<?php echo $fila["iDNI"]; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sDomicilio" class="col-4">Domicilio</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm" name="sDomicilio" id="sDomicilio" value="<?php echo $fila["sDomicilio"]; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sEmail" class="col-4">Email</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm" name="sEmail" id="sEmail" value=<?php echo $fila["sEmail"]; ?>>
                                    </div>
                                </div>
                                    <div  class="float-sm-right">
                                        <div class="form-group">
                                            <button type="submit" name="nCambiar" id="iCambiar" class="btn btn-outline-dark btn-sm">Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
</form>


<?php
    include '../Libs/footer.php';
?>