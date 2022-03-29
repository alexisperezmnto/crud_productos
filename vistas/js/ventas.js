//VARIABLES
var total = 0;

//TABLA PRODUCTOS
var tablaProductosVentas = $('.tablaProductosVentas').DataTable({
    "ajax": "ajax/datatable-productos-ventas.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "bInfo": false,
    "bLengthChange": false,
    "pageLength": 4,
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

//AGREGAR PRODUCTOS
$(document).on('click', '.btnAgregarrProducto', function() {

    var idProducto = $(this).attr('idProducto');
    var nombre = $(this).attr('nombre');
    var referencia = $(this).attr('referencia');
    var precio = $(this).attr('precio');
    var stock = $(this).attr('stock');

    //Verificar stock
    if(stock == 0) {
        swal.fire({
            icon: "warning",
            text: "El producto se encuentra sin stock.",
            confirmButtonText: "Cerrar"
        });
        return;
    }

    $('.cancelarVenta').attr('disabled', false);
    $('.guardarVenta').attr('disabled', false);

    //Verificar si el producto ya fue agregado
    var continuar = true;
    $('.tablaProductosAgregados > tbody > tr').each(function(index, tr) {
        if($(this).find('td:eq(2) input').attr('idProducto') == idProducto) {
            continuar = false;
            swal.fire({
                icon: "warning",
                text: "El producto ya ha sido agregado.",
                confirmButtonText: "Cerrar"
            });
        }
    });
    
    if(!continuar) return;

    $('.mensaje').css('display', 'none');
    $('.tablaProductosAgregados').css('display', 'block');

    $('.tablaProductosAgregados > tbody').append(
        `<tr>
            <td><i class="fa fa-times quitarProducto" style="cursor: pointer; color: red"></i></td>
            <td>${nombre}</td>                 
            <td><input type="number" 
                class="form-control cantidad" 
                value="1" 
                idProducto="${idProducto}" 
                nombre="${nombre}" 
                referencia="${referencia}" 
                precio="${precio}" 
                stock="${stock}" 
                min="1" 
                onkeyup="if(this.value <= 0)this.value = 1">
            </td>
            <td id="td_${idProducto}">$${precio}</td>
        </tr>`
    );

    //Total
    calcularTotal()

});

//QUITAR PRODUCTO
$(document).on('click', '.quitarProducto', function() {
    $(this).closest ('tr').remove();

    //Total
    calcularTotal()

    if($('.tablaProductosAgregados > tbody > tr').length <= 0) {
        limipiarFormVenta()
    }
});

//CANTIDAD
$(document).on('change', '.cantidad', function() {

    var idProducto = $(this).attr('idProducto');
    var stock = $(this).attr('stock');
    var cantidad = $(this).val();
    var precio = $(this).attr('precio');

    //Verificar cantidad ingresada no supere stock
    if(Number(cantidad) > stock) {
        swal.fire({
            icon: "warning",
            text: "La cantidad no puede superar el stock.",
            confirmButtonText: "Cerrar"
        });

        $(this).val(1).change();

        return;
    }

    var subTotal = Number(cantidad) * Number(precio);
    $('#td_'+idProducto).html('$'+subTotal)

    //Total
    calcularTotal()
});

//GUARDAR VENTA
$(document).on('click','.guardarVenta', function() {
    var productos = [];

    $('.tablaProductosAgregados > tbody > tr').each(function(index, tr) {
        var id = $(this).find('td:eq(2) input').attr('idProducto')
        var nombre = $(this).find('td:eq(2) input').attr('nombre')
        var referencia = $(this).find('td:eq(2) input').attr('referencia')
        var precio = $(this).find('td:eq(2) input').attr('precio')
        var cantidad = $(this).find('td:eq(2) input').val()

        var producto = {
            id,
            nombre,
            referencia,
            precio,
            cantidad
        }

        productos.push(producto)
    });
    
    var datos = new FormData();
    
	datos.append('usuario', $('#idUsuario').val());
	datos.append('productos', JSON.stringify(productos));
	datos.append('total', total);
    
	swal.fire({
		text: '¿Está seguro de guardar la venta?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Guardar',
		cancelButtonText: 'Cancelar'
	}).then((result)=>{
		if(result.value) {
			$.ajax({
				url:"ajax/ventas.ajax.php",
				method:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				success: function(respuesta) {
                    if(respuesta == 'stock') {
                        swal.fire({
							icon: "error",
							text: "Alguno de los productos se encuentra sin stock. Por favor verifique la cantidad.",
							confirmButtonText: "Cerrar"
						});
                    } else if(respuesta == 'ok') {
						tablaProductosVentas.ajax.reload();
						
                        limipiarFormVenta()

                        swal.fire({
							icon: "success",
							text: "¡La venta se ha guardado correctamente!",
							confirmButtonText: "Cerrar"
						});
					} else {
						tablaProductosVentas.ajax.reload();
						swal.fire({
							icon: "error",
							text: "Se produjo un error.",
							confirmButtonText: "Cerrar"
						});
					}
				}
			});
		}
	})
})

//CANCELAR VENTA
$(document).on('click', '.cancelarVenta', function() {
    limipiarFormVenta()
});

//FUNCIONES
function calcularTotal() {
    var calTotal = 0;

    $('.tablaProductosAgregados > tbody > tr').each(function(index, tr) {
        calTotal += Number($(this).find('td:eq(3)').text().replace('$', ''));
    });

    $('.divTotal').html(`Total: $${calTotal}`).css('display', 'block');
    total = calTotal
}

function limipiarFormVenta() {
    total = 0;
    
    $('.tablaProductosAgregados > tbody').html('');
    $('.tablaProductosAgregados').css('display', 'none');
    $('.divTotal').css('display', 'none');
    $('.mensaje').css('display', 'block');

    $('.cancelarVenta').attr('disabled', true);
    $('.guardarVenta').attr('disabled', true);
}


