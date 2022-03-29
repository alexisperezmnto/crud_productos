<?php
    $tabla = "usuarios";
    $item = "id";
    $valor = $_SESSION['id'];
    $usuario = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);
?>

<style>
    .formVenta {
        border: 1px solid #c4c4c4;
        padding: 0 30px 0 30px;
    }

    .formVenta, .tablaProducto {
        border: 1px solid #c4c4c4;
        padding: 30px;
    }

    thead, tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .divTotal {
        font-weight: bold;
        margin-right: 50px;
        display: none;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <h1>Ventas</h1>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <!-- Formulario venta -->
            <div class="col-md-5">
                <form role="form" method="post" class="formVenta">
                    <div class="text-center"><h4>Nueva Venta</h4></div>
                    <div class="form-group">
                        <label for="titulo">Usuario</label>
                        <input type="text" name="usuario" class="form-control" id="usuario" value="<?php echo $usuario["nombre"] ?>" disabled>
                        <input type="hidden" id="idUsuario" value="<?php echo $usuario["id"] ?>">
                    </div>
                    
                    <div class="divProductosAgregados">
                        <p class="my-5 mensaje">No hay productos agregados</p>

                        <table class="table tablaProductosAgregados" style="display: none">
                            <thead>
                                <tr>
                                    <th>Quitar</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody style="display: block; height: 150px; overflow: auto">
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right mt-2 divTotal">
                        
                    </div>

                    <div class="text-right mt-2">
                        <button type="button" class="btn btn-secondary cancelarVenta" disabled>Cancelar</button>
                        <button type="button" class="btn btn-primary guardarVenta" disabled>Guardar</button>
                    </div>
                </form>
            </div>

            <!-- Tabla productos -->
            <div class="col-md-7">
                <div class="tablaProducto">
                    <h4>Productos</h4>
                    <table class="table table-bordered table-striped dt-responsive tablaProductosVentas">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Referencia</th>
                                <th>Precio</th>
                                <th>Peso</th>
                                <th>Stock</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td><img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail" width="40px"></td>
                            <td>Producto</td>
                            <td>NOP90</td>       
                            <td>2000</td>                 
                            <td>15</td>
                            <td>500</td>
                            <td>                 
                                <i class="fa fa-plus" style="cursor:pointer"></i>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
