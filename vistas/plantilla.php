<?php
  // session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CRUD Productos</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="vistas/img/plantilla/logo.jpg">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="vistas/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="vistas/css/custom.css">

  <!-- jQuery -->
  <script src="vistas/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="vistas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Datatables -->
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  

</head>

<body class="hold-transition sidebar-collapse sidebar-mini">
  
  <?php
    echo '<div class="wrapper">';
    if(isset($_GET['ruta'])) {

        if($_GET['ruta'] == 'inicio' ||
            $_GET['ruta'] == 'productos' ||
            $_GET['ruta'] == 'ventas' ||
            $_GET['ruta'] == 'reporte' ||
            $_GET['ruta'] == 'usuarios' ||
            $_GET['ruta'] == 'salir') {
                if(isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == 'ok') {
                    
            
                    include "modulos/header.php";
            
                    include "modulos/sidebar.php"; 
                    
                    include 'modulos/'.$_GET['ruta'].'.php';

            
                    include "modulos/footer.php";
                } else {
                    echo '<script>window.location = "/crud_productos"</script>';
                }
        } else {
            echo '<script>window.location = "/crud_productos"</script>';
        }
    } else {
        include 'modulos/index.php';
    }
    echo '</div>';

  ?>

  
  </div>

</div>

<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/productos.js"></script>
<script src="vistas/js/ventas.js"></script>
<script src="vistas/js/reporte.js"></script>

</body>
</html>
