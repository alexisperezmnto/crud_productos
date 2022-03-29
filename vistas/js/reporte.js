$(document).ready(function(){
    
    //PRODUCTO CON MAYOR STOCK
	var datos = new FormData();
	datos.append("mayorStock", true);

	$.ajax({
		url:"ajax/ventas.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
        dataType:"json",
		success: function(respuesta) {
			$('.mayorStock').html(`Producto con mayor stock: ${respuesta.nombre} (${respuesta.stock} unidades)`)
            
		}
	});

    //PRODUCTO MÁS VENDIDO
	var datos = new FormData();
	datos.append("masVendido", true);

	$.ajax({
		url:"ajax/ventas.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
        dataType:"json",
		success: function(respuesta) {
			$('.masVendido').html(`Producto más vendido: ${respuesta.nombre} (${respuesta.cantidad} unidades)`)
		}
	});
});

//TABLA PRODUCTOS
var tablaVentas = $('.tablaVentas').DataTable({
    "ajax": "ajax/datatable-reporte-ventas.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "bInfo": false,
    "bLengthChange": false,
    "order": [[ 1, "desc" ]],
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "NingÃºn dato disponible en esta tabla",
        "sInfo":           "Registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty":      "Registros del 0 al 0 de un total de 0",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Ãšltimo",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
}); 

//DETALLES VENTA
$(document).on('click','.detalleVenta', function(){
	var idVenta = $(this).attr("idVenta");
	var fecha = $(this).attr("fecha");
	var usuario = $(this).attr("usuario");
	var total = $(this).attr("total");
	
	var datos = new FormData();
	datos.append("idVenta",idVenta);

	$.ajax({
		url:"ajax/ventas.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
        dataType:"json",
		success: function(respuesta) {
			
            $('.divDetalleVenta').html(`
                <p><b>Fecha: </b> ${fecha}</p>
                <p><b>Usuario: </b> ${usuario}</p>

                <div class="text-center mb-3">
                    <h4>Productos</h4>
                </div>

                <table class="table tablaProductosVenta">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Referencia</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody style="display: block; height: 200px; overflow: auto">
                        
                    </tbody>
                </table>

                <div class="text-right mt-2 divTotal" style="margin-right: 80px; font-weight:bold">
                    Total: $${total}
                </div>
            `);

            for(producto of respuesta) {
                $('.tablaProductosVenta > tbody').append(
                    `<tr>
                        <td><img src="${producto.imagen}" class="img-thumbnail" width='40px'></td>
                        <td>${producto.nombre}</td>
                        <td>${producto.referencia}</td>
                        <td>${producto.cantidad}</td>
                        <td>$${producto.precio}</td>
                    </tr>`
                );
            }
            $('#modalDetalleVenta').modal('show');
		}
	});
});


