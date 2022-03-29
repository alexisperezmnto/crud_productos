<style>
  .formProducto {
        border: 1px solid #c4c4c4;
        padding: 30px;
    }
</style>

<div class="content-wrapper">
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
            <h1>Productos</h1>
            <button type='button' class="btn btn-primary btn-sm mt-2" 
              data-toggle="modal" data-target="#modalProducto">
              <span class="glyphicon glyphicon-plus" ></span> Nuevo Producto</button>
          </div>
        </div>
      </div>
    </section>

    <section class="content">

      <table class="table table-bordered table-striped dt-responsive tablaProductos">
          <thead>
            <tr>
              <th>Id</th>
              <th>Imagen</th>
              <th>Nombre</th>
              <th>Referencia</th>
              <th>Precio</th>
              <th>Peso</th>
              <th>Categoría</th>
              <th>Stock</th>
              <th>Acción</th>
            </tr>
          </thead>
      </table>	

    </section>
    
</div>


<!-- Modal nuevo producto-->
<div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="post" class="formProducto" enctype="multipart/form-data">
          <div class="form-group">
            <label for="titulo">Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre">
          </div>
          
          <div class="form-group">
            <label for="titulo">Referencia</label>
            <input type="text" name="referencia" class="form-control" id="referencia">
          </div>

          <div class="form-group">
            <label for="titulo">Precio</label>
            <input type="text" name="precio" class="form-control" id="precio" OnKeypress='return solo_numero(event)'>
          </div>

          <div class="form-group">
            <label for="titulo">Peso</label>
            <input type="text" name="peso" class="form-control" id="peso" OnKeypress='return solo_numero(event)'>
          </div>

          <div class="form-group">
            <label for="categoria">Categoría</label>
            <select id="categoria" name="categoria" class="form-control input-lg">
                <option value="">Seleccionar categoría</option>
                <?php
                  $item = null;
                  $valor = null;
                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {
                    echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                  }
                ?>
            </select>
          </div>

          <div class="form-group">
            <label for="titulo">Stock</label>
            <input type="text" name="stock" class="form-control" id="stock" OnKeypress='return solo_numero(event)'>
          </div>
          
          <div class="form-group mt-5">
            <label for="imagenProducto">Imagen</label><br>
            <input type="file" class="imagenProducto" name="imagenProducto" id="imagenProducto">
            <p class="help-block">Peso máximo de la foto: 20 MB</p>
            <img src="" class="img-thumbnail previsualizar" width="30%">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
          
          <input type="hidden" id="idProducto" name="idProducto">
          <input type="hidden" id="imagenActual" name="imagenActual">
        </form>
      </div>
      
    </div>
  </div>
</div>