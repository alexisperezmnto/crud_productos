<?php

  if($_SESSION['perfil'] != 'Administrador') {
    echo '<script>window.location = "/crud_productos/inicio"</script>';
  }

?>

<style>
  .formUsuario, .formEditarUsuario {
    border: 1px solid #c4c4c4;
  }
</style>

<div class="content-wrapper">
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
            <h1>Usuarios</h1>
            <button type='button' class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#modalNuevoUsuario"><span class="glyphicon glyphicon-plus" ></span> Nuevo Usuario</button>
          </div>
        </div>
      </div>
    </section>

    <section class="content">

      <table class="table table-bordered table-striped dt-responsive tablaUsuarios">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th>Usuario</th>
              <th>Foto</th>
              <th>Perfil</th>
              <th>Estado</th>
              <th>Acción</th>
            </tr>
          </thead>
      </table>	

    </section>
    
</div>


<!-- Modal nuevo usuario-->
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="post" class="formUsuario" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" class="form-control" id="nombre" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="form-group">
              <label for="usuario">Usuario</label>
              <input type="text" name="usuario" class="form-control" id="usuario" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="form-group">
              <label for="perfil">Perfil</label>
              <select id="perfil" name="perfil" class="form-control" required>
                <option value=""></option>
                <option value="Administrador">Administrador</option>
                <option value="Usuario">Usuario</option>
              </select>
            </div>
            <div class="form-group">
              <label for="nuevaFoto">Foto</label><br>
              <input type="file" class="nuevaFoto" name="nuevaFoto" id="nuevaFoto">
              <p class="help-block">Peso máximo de la foto: 20 MB</p>
              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
            </div>
          </div>
          <!-- /.card-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal editar usuario-->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Editar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form role="form" method="post" class="formEditarUsuario" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group">
                <label for="editarNombre">Nombre</label>
                <input type="text" name="editarNombre" class="form-control" id="editarNombre" required>
                <input type="hidden" id="idUsuario" name="idUsuario">
              </div>
              <div class="form-group">
                <label for="editarEmail">Email</label>
                <input type="email" name="editarEmail" class="form-control" id="editarEmail" required>
                <input type="hidden" id="emailActual" name="emailActual">
              </div>
              <div class="form-group">
                <label for="editarUsuario">Usuario</label>
                <input type="text" name="editarUsuario" class="form-control" id="editarUsuario" required>
                <input type="hidden" id="usuarioActual" name="usuarioActual">
              </div>
              <div class="form-group">
                <label for="editarPassword">Password</label>
                <input type="password" name="editarPassword" class="form-control" id="editarPassword">
                <input type="hidden" id="passwordActual" name="passwordActual">
              </div>
              <div class="form-group">
                <label for="editarPerfil">Perfil</label>
                <select id="editarPerfil" name="editarPerfil" class="form-control" required>
                  <option value="Administrador">Administrador</option>
                  <option value="Usuario">Usuario</option>
                </select>
              </div>
              <div class="form-group">
                <label for="nuevaFoto">Foto</label><br>
                <input type="file" class="nuevaFoto" name="editarFoto">
                <p class="help-block">Peso máximo de la foto: 20 MB</p>
                <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                <input type="hidden" id="fotoActual" name="fotoActual">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>