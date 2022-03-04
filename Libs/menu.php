<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/CarrodeCompras/">
<div class="d-none d-sm-block"><img src="https://seeklogo.com/images/P/playstation-logo-A5B6E4856C-seeklogo.com.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy"> Ya podes comprar Online en Nuestro Sitio Web</div>
<div class="d-block d-sm-none"><img src="https://seeklogo.com/images/P/playstation-logo-A5B6E4856C-seeklogo.com.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy"> Compra Online</div>
</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
  </ul>
    <ul class="navbar-nav navbar-right">
      <?php if(!isset($_SESSION["iIdUsuario"])){ ?>
          <li class="nav-item active">
            <a class="nav-link" href="/CarrodeCompras/Acceso/login.php"><i class="far fa-user mr-2"></i>Iniciar Sesion</a>
          </li>
      <?php }else{ ?>
        <li class="nav-item">
            <a class="nav-link" href="/CarrodeCompras/CarroCompras/"><i class="fas fa-shopping-cart mr-2"></i><span class="badge badge-light rounded-circle"></span></a>
          </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo '<i class="far fa-user mr-2"></i>'. $_SESSION["sLogin"]; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/CarrodeCompras/Usuario/"><i class="far fa-user mr-2"></i>Mi Cuenta</a>
          <?php
                if($_SESSION["sSalt"]=='Admin'){
                  echo '<a class="dropdown-item" href="/CarrodeCompras/Producto/"><i class="far fa-file-alt mr-2"></i>Productos</a>';
                }
          ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/CarrodeCompras/Acceso/logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesion</a>
        </div>
      </li>
    </ul>
      <?php } ?>
  </div>
</nav>