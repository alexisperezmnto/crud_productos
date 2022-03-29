<style>
    .mayorStock {
        margin-top: 30px;
        font-weight: bold;
        font-size: 18px;
    }

    .masVendido {
        margin-top: 10px;
        font-weight: bold;
        font-size: 18px;
    }

    thead, tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>

<div class="content-wrapper">
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
            <h1>Reporte Ventas</h1>
            
            <!-- PRODUCTO CON MAYOR STOCK -->
            <p class="mayorStock"></p>
            
            <!-- PRODUCTO MÁS VENDIDO -->
            <p class="masVendido"></p>

          </div>
        </div>
      </div>
    </section>

    <section class="content">

      <table class="table table-bordered table-striped dt-responsive tablaVentas">
          <thead>
            <tr>
              <th>Id</th>
              <th>Fecha</th>
              <th>Usuario</th>
              <th>Total</th>
              <th>Acción</th>
            </tr>
          </thead>
      </table>	

    </section>
    
</div>


<!-- MODAL DETALLE VENTA-->
<div class="modal fade" id="modalDetalleVenta" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body divDetalleVenta">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>