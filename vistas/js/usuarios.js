var tablaUsuarios = $('.tablaUsuarios').DataTable({
      "ajax": "ajax/datatable-usuarios.ajax.php",
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


/*=============================================
=            SUBIENDO FOTO DEL USUARIO        =
=============================================*/

$('.nuevaFoto').change(function() {
	var imagen = this.files[0];
	
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
		$('.nuevaFoto').val('');
		swal.fire({
			text:"Error al subir imagen. La imagen debe estar en formato JPG o PNG.",
			icon:"error",
			confirmButtonText:"Cerrar"
		});
	} else if(imagen["size"] > 20000000) {
		$('.nuevaFoto').val(''); 
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


/*=============================================
=            ACTIVAR USUARIO        =
=============================================*/

$(document).on('click','.btnActivar', function(){
	var idUsuario = $(this).attr('idUsuario');
	var estadoUsuario = $(this).attr('estadoUsuario');


	var datos = new FormData();
	datos.append("activarId", idUsuario);
	datos.append("activarUsuario", estadoUsuario);


	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		success:function(respuesta) {
			
		}
	})

	if(estadoUsuario == 0) {
		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('Desactivado');
		$(this).attr('estadoUsuario',1);
	} else {
		$(this).removeClass('btn-danger');
		$(this).addClass('btn-success');
		$(this).html('Activado');
		$(this).attr('estadoUsuario',0);
	}
})


//GUARDAR USUARIO
$('.formUsuario').on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: "ajax/guardarUsuario.ajax.php",
		type: "POST",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(respuesta){

			respuesta = respuesta.split(',');

			if(respuesta[0] == 'ok') {
				tablaUsuarios.ajax.reload(null, false);
				swal.fire({
					icon: "success",
					text: "¡El usuario ha sido registrado correctamente!",
					confirmButtonText: "Cerrar"
				}).then(function(){
					$('#modalNuevoUsuario').modal('hide');
				});
			} 
			
			if(respuesta[0] == 'Existe'){
		        swal.fire({
		          icon: "error",
		          text: "¡El" + respuesta[1] + " ya existe en la base de datos!",
		          confirmButtonText: "Cerrar"
		        })
			 } 
			 
			if(respuesta[0] == 'error') {
				swal.fire({
					icon: "error",
					text: "¡Complete los campos requeridos. Recuerde no usar caracteres especiales!",
					confirmButtonText: "Cerrar"
				})
			}
		}	 
	});
})

/*=============================================
=            EDITAR USUARIO        =
=============================================*/

$(document).on('click','.btnEditarUsuario', function(){
	var idUsuario = $(this).attr("idUsuario");
	
	var datos = new FormData();
	datos.append("idUsuario",idUsuario);

	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success: function(respuesta) {
			$('#idUsuario').val(respuesta['id']);
			$('#editarNombre').val(respuesta['nombre']);
			$('#editarEmail').val(respuesta['email']);
			$('#emailActual').val(respuesta['email']);
			$('#editarUsuario').val(respuesta['usuario']);
			$('#usuarioActual').val(respuesta['usuario']);
			$('#editarPerfil').val(respuesta['perfil']);
			$('#fotoActual').val(respuesta['foto']);
			$('#passwordActual').val(respuesta['password']);

			if(respuesta['foto'] != "") {
				$('.previsualizar').attr("src",respuesta['foto']);
			} else {
				$('.previsualizar').attr("src","vistas/img/usuarios/default/anonymous.png");
			}
		}
	});
})

//EDITAR USUARIO
$('.formEditarUsuario').on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: "ajax/guardarUsuario.ajax.php",
		type: "POST",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(respuesta){

			respuesta = respuesta.split(',');

			if(respuesta[0] == 'ok') {
				tablaUsuarios.ajax.reload(null, false);
				swal.fire({
					icon: "success",
					text: "¡El usuario ha sido editado correctamente!",
					confirmButtonText: "Cerrar"
				}).then(function(){
					$('#modalEditarUsuario').modal('hide');
				});
			} 
			
			if(respuesta[0] == 'Existe'){
		        swal.fire({
		          icon: "error",
				  text: "¡El" + respuesta[1] + " ya existe en la base de datos!",
		          confirmButtonText: "Cerrar"
		        })
			 }
			 
			 if(respuesta[0] == 'error'){
				swal.fire({
					icon: "error",
					text: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
					confirmButtonText: "Cerrar"
				})
			}
		}	 
	});
})



/*=============================================
=            EDITAR PERFIL USUARIO        =
=============================================*/

$(document).on('click','.btnEditarPerfilUsuario', function(){
	var idUsuario = $(this).attr("idUsuario");
	
	var datos = new FormData();
	datos.append("idUsuario",idUsuario);

	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success: function(respuesta) {
			$('#idUsuarioPerfil').val(respuesta['id']);
			$('#editarPerfilNombre').val(respuesta['nombre']);
			$('#editarPerfilEmail').val(respuesta['email']);
			$('#emailActualPerfil').val(respuesta['email']);
			$('#editarPerfilUsuario').val(respuesta['usuario']);
			$('#usuarioActualPerfil').val(respuesta['usuario']);
			$('#fotoActualPerfil').val(respuesta['foto']);
			$('#passwordActualPerfil').val(respuesta['password']);

			if(respuesta['foto'] != "") {
				$('.previsualizar').attr("src",respuesta['foto']);
			} else {
				$('.previsualizar').attr("src","vistas/img/usuarios/default/anonymous.png");
			}
		}
	});
})

//EDITAR PERFIL USUARIO
$('.formEditarPerfilUsuario').on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: "ajax/guardarUsuario.ajax.php",
		type: "POST",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(respuesta){

			respuesta = respuesta.split(',');

			if(respuesta[0] == 'ok') {
				swal.fire({
					icon: "success",
					text: "¡El usuario ha sido editado correctamente!",
					confirmButtonText: "Cerrar"
				}).then(function(){
					window.location = "/crud_productos/inicio"
				});
			} 
			
			if(respuesta[0] == 'Existe'){
		        swal.fire({
		          icon: "error",
				  text: "¡El" + respuesta[1] + " ya existe en la base de datos!",
		          confirmButtonText: "Cerrar"
		        })
			 }
			 
			 if(respuesta[0] == 'error'){
				swal.fire({
					icon: "error",
					text: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
					confirmButtonText: "Cerrar"
				})
			}
		}	 
	});
})


/*=============================================
=       ELIMINAR USUARIO       			      =
=============================================*/

$(document).on('click','.btnEliminarUsuario', function(){
	var idUsuario = $(this).attr('idUsuario');
	var fotoUsuario = $(this).attr('fotoUsuario');
	var usuario = $(this).attr('usuario');

	var datos = new FormData();
	datos.append('eliminarUsuario', idUsuario);
	datos.append('fotoUsuario', fotoUsuario);
	datos.append('usuario', usuario);

	swal.fire({
		text: '¿Está seguro de eliminar el usuario?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Eliminar',
		cancelButtonText: 'Cancelar'
	}).then((result)=>{
		if(result.value) {
			$.ajax({
				url:"ajax/usuarios.ajax.php",
				method:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				dataType:"json",
				success: function(respuesta) {
					if(respuesta == 'ok') {
						tablaUsuarios.ajax.reload();
						swal.fire({
							icon: "success",
							text: "¡El usuario ha sido eliminado correctamente!",
							confirmButtonText: "Cerrar"
						})
					} else if(respuesta == 'error2') {
						tablaUsuarios.ajax.reload();
						swal.fire({
							icon: "error",
							text: "No es posbible eliminar la cuenta del administrador.",
							confirmButtonText: "Cerrar"
						})
					} else {
						tablaUsuarios.ajax.reload();
						swal.fire({
							icon: "error",
							text: "Se produjo un error al eliminar el usuario.",
							confirmButtonText: "Cerrar"
						})
					}
				}
			});
		}
	})

	
})


//LOGIN
$('.inicioSesionForm').on('submit', function(e) {
	e.preventDefault();
	
	$.ajax({
		url: "ajax/inicioSesion.ajax.php",
		type: "POST",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(respuesta){
			
			respuesta = respuesta.split(',');

			if(respuesta == 'ok') {
				swal.fire({
					icon: "success",
					text: "¡Bienvenido!",
					confirmButtonText: "Cerrar"
				}).then(function(){
					window.location = "/crud_productos/inicio"
				});
			} 
			
			if(respuesta == 'no activo'){
		        swal.fire({
		          icon: "error",
				  text: "¡El usuario no se encuentra activo. Comuníquese con el administrador!",
		          confirmButtonText: "Cerrar"
		        })
			 }
			 
			 if(respuesta == 'error'){
				swal.fire({
					icon: "error",
					text: "¡Usuario o contraseña inválidos!",
					confirmButtonText: "Cerrar"
				})
			}
		}	 
	});
})


$('#modalNuevoUsuario').on('hidden.bs.modal', function(e)
    { 
        $('#nombre').val('');
        $('#email').val('');
        $('#usuario').val('');
        $('#password').val('');
        $('#perfil').prop('selectedIndex',0);
        $('#nuevaFoto').val("");;
        $('.previsualizar').attr("src","vistas/img/usuarios/default/anonymous.png");
    }) ;


$('#modalEditarUsuario').on('hidden.bs.modal', function(e)
    { 
        $('.previsualizar').attr("src","vistas/img/usuarios/default/anonymous.png");
        $('#editarPassword').val('');
        $('#passwordActual').val('');
    }) ;

$('#modalEditarPerfilUsuario').on('hidden.bs.modal', function(e)
{ 
	$('.previsualizar').attr("src","vistas/img/usuarios/default/anonymous.png");
	$('#editarPerfilPassword').val('');
	$('#passwordActualPerfil').val('');
}) ;

