<?php
    include '../Libs/header.php';
?>
<?php
    if(!empty($_POST)){
        $sLogin=$_POST["txtUsuario"];
        $sClave=$_POST["txtClave"];
        $sNombre=$_POST["txtNombre"];
        $sApellido=$_POST["txtApellido"];
        $sEmail=$_POST["txtEmail"];
        $iDNI=$_POST["txtDNI"];
        $sDomicilio=$_POST["txtDomicilio"];

        $sql="Insert into usuarios(sLogin,sClave,sNombre,sApellido,sEmail,sDomicilio,iDNI) values(?,?,?,?,?,?,?)";
        $datos=preparar_query($conexion,$sql,[$sLogin,$sClave,$sNombre,$sApellido,$sEmail,$sDomicilio,$iDNI]);
        if($datos){
            $mje="Registro agregado correctamente ";
        }else{
            $mje="Error: ". $sql ." ".$datos->error;
        }
    }
    ?>
    <body>
    <?php 
        if(isset($mje)){
            echo '<div class="alert alert-success">';
            echo $mje." ";
            echo '<a class="btn btn-primary btn-sm" href="../Acceso/login.php" role="button">Log in</a>'; 
            echo '</div>';
    }
    ?>

<br>
Volver al Login <a href="../Acceso/login.php">(Volver)</a>
<form id="loginform" action="create.php" method="POST">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="txtUsuario">Username</label>
      <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="Username">
    </div>
    <div class="form-group col-md-6">
      <label for="txtClave">Password</label>
      <input type="password" class="form-control" name="txtClave" id="txtClave" placeholder="Password">
    </div>
  </div>

  <div class="form-row">  
    <div class="form-group col-md-6">
        <label for="txtNombre">Nombre</label>
        <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Name">
    </div>
    <div class="form-group col-md-6">
        <label for="txtApellido">Apellido</label>
        <input type="text" class="form-control" name="txtApellido" id="txtApellido" placeholder="Surname">
    </div>
  </div>  

  <div class="form-row">
    <div class="form-group col-md-2">
      <label for="txtDNI">DNI</label>
      <input type="text" class="form-control" name="txtDNI" id="txtDNI" placeholder="44444444">
    </div>
    <div class="form-group col-md-4">
      <label for="txtDomicilio">Domicilio</label>
      <input type="text" class="form-control" name="txtDomicilio" id="txtDomicilio" placeholder="Domicilio">
    </div>
    <div class="form-group col-md-6">
      <label for="txtEmail">E-mail</label>
      <input type="text" class="form-control" name="txtEmail" id="txtEmail" placeholder="example@gmail.com">
    </div>
  </div>

  <button type="submit" class="btn btn-outline-dark">Sign in</button>
</form>


<?php
    include '../Libs/footer.php';
?>