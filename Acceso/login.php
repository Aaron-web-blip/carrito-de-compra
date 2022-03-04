<?php
	include "../libs/header.php";
?>
<?php
	if(!empty($_POST)){
			
		$usuario= $_POST["txtUsuario"];
		$contraseña=$_POST["txtContraseña"];
		
        $sql="select * from usuarios where sLogin=?";
		$datos= preparar_select($conexion,$sql,[$usuario]);
		if($datos->num_rows>0)
		{
			$fila= $datos-> fetch_assoc();
			if($contraseña==$fila["sClave"]){

				if($fila["bEliminado"]==0)
				{
					$_SESSION["iIdUsuario"]=$fila["iIdUsuario"];
					$_SESSION["sLogin"]=$fila["sLogin"];
					$_SESSION["sSalt"]=$fila["sSalt"];
					$_SESSION["sNombre"]=$fila["sNombre"];
					$_SESSION["sApellido"]=$fila["sApellido"];
					$_SESSION["sDomicilio"]=$fila["sDomicilio"];
					$_SESSION["sEmail"]=$fila["sEmail"];
					$_SESSION["iDNI"]=$fila["iDNI"];
					header("location: /CarrodeCompras/");
				}
				else
				{
					$mje="El Usuario fue Eliminado";
				}
				
			}
			else
			{
				$mje="Contraseña Incorrecta";
			}
		}
		else
		{
			$mje="Usuario Incorrecto";
		}
	}
?>
<br>
		<?php
			if(isset($mje)){
				echo '<div class="alert alert-danger">';
				echo $mje." ";
				echo '<a class="btn btn-primary btn-sm" href="../Usuario/create.php" role="button">Registrate</a>'; 
				echo '</div>';
		}
		?>
<form id="loginform" action=login.php method="POST">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Usuario</label>
    <div class="col-sm-10">
      <input type="text" class="form-control"  name='txtUsuario' id='txtUsuario' placeholder="Username">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label" >Contraseña</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name='txtContraseña' id='txtContraseña' placeholder="Password">
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-outline-dark">Iniciar Sesion</button>
	  <a class="btn btn-outline-primary" href="../Usuario/create.php" role="button">Registrate</a>
    </div>
  </div>
</form>



<?php
	include '../Libs/footer.php';
?>