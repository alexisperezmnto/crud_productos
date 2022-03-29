<?php

  $tabla = "usuarios";
  $item = "id";
  $valor = $_SESSION['id'];
  $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);

?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link">
            <?php 
              if($respuesta['foto'] == '') {
                $foto = 'vistas/img/usuarios/default/anonymous.png';
              } else {
                $foto = $respuesta['foto'];
              }
            ?>
            <img src="<?php echo $foto ?>" class="img-circle mr-2" width="35" height="35">
            <?php echo $respuesta['nombre'] ?>
        </a>
      </li>
    </ul>
  </nav>


 