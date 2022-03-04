
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/CarrodeCompras/">Ver Todos</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="nav nav-pills nav-fill">
    <?php
    $sql="select * from Categorias where bEliminado=0";
    $categorias= preparar_select($conexion,$sql);
    foreach($categorias as $categoria){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="/CarrodeCompras/index.php?iIdCategoria=<?php echo $categoria['iIdCategoria']; ?>"><?php echo $categoria["sNombre"]; ?></a>
      </li>
      <?php
        }
      ?>
    </ul>
  </div>
</nav>
<br>