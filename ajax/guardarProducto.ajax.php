<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


//GUARDAR NUEVO PRODUCTO
if(isset($_POST['idProducto']) && $_POST['idProducto'] == '') { 
	if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nombre']) &&
		preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['referencia']) &&
		preg_match('/^[0-9.,]+$/', $_POST['precio']) && 
		preg_match('/^[0-9.,]+$/', $_POST['peso']) &&
		preg_match('/^[0-9]+$/', $_POST['categoria']) &&
		preg_match('/^[0-9]+$/', $_POST['stock'])) {

		/*======================================
		=            VALIDAR IMAGEN            =
		======================================*/
		
		$tabla = "usuarios";
		$item = "id";
		$valor = $_SESSION['id'];
		$usuario = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);
		
		$ruta = 'vistas/img/productos/default/anonymous.png';

		if(isset($_FILES['imagenProducto']['tmp_name']) && $_FILES['imagenProducto']['tmp_name'] != "") {
			list($ancho, $alto) = getimagesize($_FILES['imagenProducto']['tmp_name']);

			$nuevoAncho = 500;
			$nuevoAlto = 500;

			$directorio = '../vistas/img/productos/'.$usuario['usuario'];
			if(!file_exists($directorio)) {
				mkdir($directorio, 0755);
			}

			if($_FILES['imagenProducto']['type'] == 'image/jpeg') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/productos/'.$usuario['usuario'].'/'.$aleatorio.'.jpg';

				$origen = imagecreatefromstring(file_get_contents($_FILES['imagenProducto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagejpeg($destino, $ruta);

				$ruta = substr($ruta, 3);
			}


			if($_FILES['imagenProducto']['type'] == 'image/png') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/productos/'.$usuario['usuario'].'/'.$aleatorio.'.png';
				
				$origen = imagecreatefromstring(file_get_contents($_FILES['imagenProducto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagepng($destino, $ruta);

				$ruta = substr($ruta, 3);
			}
		}	
		

		$tabla = "productos";

		$datos = array("nombre" => $_POST['nombre'],
						"imagen" => $ruta,
						"referencia" => $_POST['referencia'],
						"precio" => $_POST['precio'],
						"peso" => $_POST['peso'],
						"categoria" => $_POST['categoria'],
						"stock" => $_POST['stock']);

		$respuesta = ModeloProductos::mdlRegistrarProducto($tabla, $datos);

		if($respuesta == 'ok') { 
			echo 'ok'; 
		}

	} else { 
		echo 'error'; 
	}
}


//EDITAR PRODUCTO
if(isset($_POST['idProducto']) && $_POST['idProducto'] != '') { 
	if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nombre']) &&
		preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['referencia']) &&
		preg_match('/^[0-9.,]+$/', $_POST['precio']) && 
		preg_match('/^[0-9.,]+$/', $_POST['peso']) &&
		preg_match('/^[0-9]+$/', $_POST['categoria']) &&
		preg_match('/^[0-9]+$/', $_POST['stock'])) {

		/*======================================
		=            VALIDAR IMAGEN            =
		======================================*/
		
		$tabla = "usuarios";
		$item = "id";
		$valor = $_SESSION['id'];
		$usuario = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);


		$ruta = $_POST['imagenActual'];

		if(isset($_FILES['imagenProducto']['tmp_name']) && !empty($_FILES["imagenProducto"]["tmp_name"])) {
			list($ancho, $alto) = getimagesize($_FILES['imagenProducto']['tmp_name']);

			$nuevoAncho = 500;
			$nuevoAlto = 500;

			$directorio = '../vistas/img/productos/'.$usuario['usuario'];

			if(!empty($ruta) && !strpos($ruta, 'anonymous')) {
				unlink('../'.$ruta);
			} else {
				if(!file_exists($directorio)) {
					mkdir($directorio, 0755);
				}
			}

			

			if($_FILES['imagenProducto']['type'] == 'image/jpeg') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/productos/'.$usuario['usuario'].'/'.$aleatorio.'.jpg';

				$origen = imagecreatefromstring(file_get_contents($_FILES['imagenProducto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagejpeg($destino, $ruta);

				$ruta = substr($ruta, 3);
			}


			if($_FILES['imagenProducto']['type'] == 'image/png') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/productos/'.$usuario['usuario'].'/'.$aleatorio.'.png';

				$origen = imagecreatefromstring(file_get_contents($_FILES['imagenProducto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagepng($destino, $ruta);

				$ruta = substr($ruta, 3);
			}
		}

		$tabla = "productos";

		$datos = array("nombre" => $_POST['nombre'],
						"imagen" => $ruta,
						"referencia" => $_POST['referencia'],
						"precio" => $_POST['precio'],
						"peso" => $_POST['peso'],
						"categoria" => $_POST['categoria'],
						"stock" => $_POST['stock'],
						"id_producto" => $_POST['idProducto']);

		$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);

		if($respuesta == 'ok') {
			echo 'ok';
		}

	} else {
			echo 'error';
	}

}
