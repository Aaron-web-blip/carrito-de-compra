<?php
    include '../Libs/header.php';
?>
<?php
    $iIdUsuario=$_SESSION["iIdUsuario"];
    $sql="SELECT * FROM usuarios where iIdUsuario=?";
    $datos=preparar_select($conexion,$sql,[$iIdUsuario]);
    foreach($datos as $dato){
?>
<br>
<div class="card mb-3" style="width: auto;">
  <div class="row no-gutters">
    <div class="col-md">
      <div class="card-body">
        <h2 class="card-title"><?php echo $dato["sNombre"]." ".$dato["sApellido"]; ?></h2>

        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center disabled">
            Username
            <span><?php echo $dato["sLogin"]; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center disabled">
            Clave 
            <span class="password"> <?php echo $dato["sClave"]; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center disabled">
             Nombre
            <span><?php echo $dato["sNombre"]; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center disabled">
             Apellido
            <span><?php echo $dato["sApellido"]; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center disabled">
             DNI
            <span><?php echo $dato["iDNI"]; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center disabled">
             Domicilio
            <span><?php echo $dato["sDomicilio"]; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center disabled">
             E-mail
            <span><?php echo $dato["sEmail"]; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center disabled">
             Fecha de Creación
            <span><?php echo $dato["dFecha"]; ?></span>
          </li>
        </ul>

        <div class="float-sm-right">
          <div class="d-flex-row">
            <div class="input-group-prepend">
            <div class="p-1"><a href="update.php?iIdUsuario=<?php echo $dato["iIdUsuario"]; ?> "class="btn btn-outline-primary btn-sm"><i class="far fa-edit mr-2"></i>Edit User</a></div>
            <div class="p-1"><a href="delete.php?iIdUsuario=<?php echo $dato["iIdUsuario"]; ?> "class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt mr-2"></i>Delete User</a></div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php
    include '../Libs/footer.php';
?>