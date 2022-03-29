//TABLA PRODUCTOS
var tablaProductos = $('.tablaProductos').DataTable({
    "ajax": "ajax/datatable-productos.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "bInfo": false,
    "bLengthChange": false,
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

//IMAGEN PRODUCTO
$('.imagenProducto').change(function() {
	var imagen = this.files[0];
	
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
		$('.imagenProducto').val('');
		swal.fire({
			text:"Error al subir imagen. La imagen debe estar en formato JPG o PNG.",
			icon:"error",
			confirmButtonText:"Cerrar"
		});
	} else if(imagen["size"] > 20000000) {
		$('.imagenProducto').val(''); 
		swal({
			text:"Error al subir imagen. La imagen no debe pesar más de 2 MB.",
			icon:"error",
			confirmButtonText:"Cerrar"
		});	
	} else {
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on('load', function(event){
			var rutaImagen = event.target.result;

			$('.previsualizar').attr('src',rutaImagen);
		})
	}
})

//GUARDAR PRODUCTO
$('.formProducto').on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: "ajax/guardarProducto.ajax.php",
		type: "POST",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(respuesta){

			if(respuesta == 'ok') {
				tablaProductos.ajax.reload(null, false);
				swal.fire({
					icon: "success",
					text: "¡El producto ha sido registrado correctamente!",
					confirmButtonText: "Cerrar"
				}).then(function(){
					$('#modalProducto').modal('hide');
				});
			} 
			
			if(respuesta == 'error') {
				swal.fire({
					icon: "error",
					text: "¡Complete los campos requeridos. Recuerde no usar caracteres especiales!",
					confirmButtonText: "Cerrar"
				})
			}
		}	 
	});
})

//EDITAR PRODUCTO
$(document).on('click','.btnEditarProducto', function(){
	var idProducto = $(this).attr("idProducto");
	
	var datos = new FormData();
	datos.append("idProducto",idProducto);

	$.ajax({
		url:"ajax/productos.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
        dataType:"json",
		success: function(respuesta) {
			$('#idProducto').val(respuesta['id']);
			$('#nombre').val(respuesta['nombre']);
			$('#referencia').val(respuesta['referencia']);
			$('#precio').val(respuesta['precio']);
			$('#peso').val(respuesta['peso']);
			$('#categoria').val(respuesta['categoria']).change();
			$('#stock').val(respuesta['stock']);
			$('#imagenActual').val(respuesta['imagen']);

			if(respuesta['imagen'] != "") {
				$('.previsualizar').attr("src",respuesta['imagen']);
			} else {
				$('.previsualizar').attr("");
			}

            $('#tituloModalProducto').text('Actualizar Producto');
            $('#modalProducto').modal('show');
		}
	});
});

//ELIMINAR PRODUCTO
$(document).on('click','.btnEliminarProducto', function(){
	var idProducto = $(this).attr('idProducto');
	var imagenProducto = $(this).attr('imagenProducto');

	var datos = new FormData();
	datos.append('eliminarProducto', idProducto);
	datos.append('imagenProducto', imagenProducto);

	swal.fire({
		text: '¿Está seguro de eliminar el producto?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Eliminar',
		cancelButtonText: 'Cancelar'
	}).then((result)=>{
		if(result.value) {
			$.ajax({
				url:"ajax/productos.ajax.php",
				method:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				dataType:"json",
				success: function(respuesta) {
					if(respuesta == 'ok') {
						tablaProductos.ajax.reload();
						swal.fire({
							icon: "success",
							text: "¡El producto ha sido eliminado correctamente!",
							confirmButtonText: "Cerrar"
						})
					} else {
						tablaProductos.ajax.reload();
						swal.fire({
							icon: "error",
							text: "Se produjo un error al eliminar el producto.",
							confirmButtonText: "Cerrar"
						})
					}
				}
			});
		}
	})
})


$('#modalProducto').on('hidden.bs.modal', function(e) { 
    $('#nombre').val('');
    $('#referencia').val('');
    $('#precio').val('');
    $('#peso').val('');
    $('#categoria').val('').change();
    $('#stock').val('');
    $('#imagenProducto').val('');
    $('.previsualizar').attr("src","");
    $('#tituloModalProducto').text('Nuevo Producto');
    $('#idProducto').val('');
    $('#imagenActual').val('');
});


//FUNCIONES

//Input sólo número
var tipo_nav = window.Event ? true : false;
function solo_numero(evt) {
    var key = tipo_nav ? evt.which : evt.keyCode;
    return (key <= 13 || (key >= 48 && key <= 57));
}