<?php
  if(isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == 'ok') {
    echo '<script>window.location = "/crud_productos/inicio"</script>';
  }
?>

<div class="container">
  <div class="card card-container">
      <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
      <p id="profile-name" class="profile-name-card"></p>
      <form class="form-signin inicioSesionForm" method="post">
          <span id="reauth-email" class="reauth-email"></span>
          <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario" required autofocus>
          <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
          <button type="submit" class="btn btn-primary">Ingresar</button>
      </form>
  </div>
</div>
