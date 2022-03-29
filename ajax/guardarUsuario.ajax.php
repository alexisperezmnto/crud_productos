<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


//GUARDAR USUARIO
if(isset($_POST['usuario'])) {
	if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nombre']) &&
		preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"]) &&
		preg_match('/^[a-zA-Z0-9_]+$/', $_POST['usuario']) &&
		preg_match('/^[a-zA-Z0-9]+$/', $_POST['password']) &&
		preg_match('/^[a-zA-Z0-9]+$/', $_POST['perfil'])) {

		//NO REPETIR USUARIO  
		$item = "usuario";
		$valor = $_POST['usuario'];
		$res = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		if($res) {
			echo 'Existe, nombre de usuario';
			return;
		} 

		//NO REPETIR EMAIL 
		$item = "email";
		$valor = $_POST['email'];
		$res = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		if($res) {
			echo 'Existe, email';
			return;
		} 

		//VALIDAR IMAGEN
		$ruta = '';

		if(isset($_FILES['nuevaFoto']['tmp_name']) && $_FILES['nuevaFoto']['tmp_name'] != "") {
			list($ancho, $alto) = getimagesize($_FILES['nuevaFoto']['tmp_name']);

			$nuevoAncho = 500;
			$nuevoAlto = 500;

			$directorio = '../vistas/img/usuarios/'.$_POST['usuario'];
			mkdir($directorio, 0755);

			if($_FILES['nuevaFoto']['type'] == 'image/jpeg') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/usuarios/'.$_POST['usuario'].'/'.$aleatorio.'.jpg';

				$origen = imagecreatefromstring(file_get_contents($_FILES['nuevaFoto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagejpeg($destino, $ruta);

				$ruta = substr($ruta, 3);
			}


			if($_FILES['nuevaFoto']['type'] == 'image/png') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/usuarios/'.$_POST['usuario'].'/'.$aleatorio.'.png';
				
				$origen = imagecreatefromstring(file_get_contents($_FILES['nuevaFoto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagepng($destino, $ruta);

				$ruta = substr($ruta, 3);
			}
		}	
		

		$tabla = "usuarios";

		$encriptar = crypt($_POST['password'],	'$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$datos = array("nombre" => $_POST['nombre'],
						"email" => $_POST['email'],
						"usuario" => $_POST['usuario'],
						"password" => $encriptar,
						"perfil" => $_POST['perfil'],
						"foto" => $ruta);

		$respuesta = ModeloUsuarios::mdlRegistrarUsuario($tabla, $datos);

		if($respuesta == 'ok') { 
			echo 'ok'; 
		}

	} else { 
		echo 'error'; 
	}
}


//EDITAR USUARIO
if(isset($_POST['editarUsuario'])) {
	if(preg_match('/^[0-9]+$/', $_POST['idUsuario']) &&
		preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarNombre']) &&
		preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarEmail"]) &&
		preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["emailActual"]) &&
		preg_match('/^[a-zA-Z0-9_]+$/', $_POST['editarUsuario']) &&
		preg_match('/^[a-zA-Z0-9_]+$/', $_POST['usuarioActual']) &&
		preg_match('/^[a-zA-Z0-9\s]*$/', $_POST['editarPassword']) &&
		preg_match('/^[a-zA-Z0-9.,\$\/]+$/', $_POST['passwordActual']) &&
		preg_match('/^[a-zA-Z0-9]+$/', $_POST['editarPerfil'])) {

		//NO REPETIR USUARIO 
		$item = "usuario";
		$valor = $_POST['editarUsuario'];
		$res = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		if($res) {
			if($res['usuario'] != $_POST['usuarioActual']){
				echo "Existe, nombre de usuario";
				return;
			}
		} 

		//NO REPETIR EMAIL
		$item = "email";
		$valor = $_POST['editarEmail'];
		$res = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		if($res) {
			if($res['email'] != $_POST['emailActual']){
				echo "Existe, email";
				return;
			}
		} 

		//VALIDAR IMAGEN
		if($_POST['editarUsuario'] != $_POST['usuarioActual']) {
			
			if($_POST['fotoActual'] != "") {
				$s = substr($_POST['fotoActual'], -7);

				$directorio = '../vistas/img/usuarios/'.$_POST['editarUsuario'];
				mkdir($directorio, 0755);

				copy('../'.$_POST['fotoActual'], $directorio.'/'.$s);
				unlink('../'.$_POST['fotoActual']);
				rmdir('../vistas/img/usuarios/'.$_POST['usuarioActual']);

				$directorio = substr($directorio, 3);
				$ruta = $directorio.'/'.$s;

			} else {
				$ruta = $_POST['fotoActual'];
			}
				
		} else {
			$ruta = $_POST['fotoActual'];
		}

		
		if(isset($_FILES['editarFoto']['tmp_name']) && !empty($_FILES["editarFoto"]["tmp_name"])) {
			list($ancho, $alto) = getimagesize($_FILES['editarFoto']['tmp_name']);

			$nuevoAncho = 500;
			$nuevoAlto = 500;

			$directorio = '../vistas/img/usuarios/'.$_POST['editarUsuario'];

			if(!empty($ruta)) {
				unlink('../'.$ruta);
			} else {
				mkdir($directorio, 0755);
			}

			

			if($_FILES['editarFoto']['type'] == 'image/jpeg') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/usuarios/'.$_POST['editarUsuario'].'/'.$aleatorio.'.jpg';

				$origen = imagecreatefromstring(file_get_contents($_FILES['editarFoto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagejpeg($destino, $ruta);

				$ruta = substr($ruta, 3);
			}


			if($_FILES['editarFoto']['type'] == 'image/png') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/usuarios/'.$_POST['editarUsuario'].'/'.$aleatorio.'.png';

				$origen = imagecreatefromstring(file_get_contents($_FILES['editarFoto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagepng($destino, $ruta);

				$ruta = substr($ruta, 3);
			}
		}

		$tabla = "usuarios";

		if($_POST["editarPassword"] != ""){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

				$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			}else{

				echo'error';

			}

		}else{

			$encriptar = $_POST["passwordActual"];

		}
		

		$datos = array("id" => $_POST['idUsuario'],
						"nombre" => $_POST['editarNombre'],
						"email" => $_POST['editarEmail'],
						"usuario" => $_POST['editarUsuario'],
						"password" => $encriptar,
						"perfil" => $_POST['editarPerfil'],
						"foto" => $ruta); 

		$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

		if($respuesta == 'ok') {
			echo 'ok';
		}

	} else {
			echo 'error';
	}

}


//EDITAR PERFIL USUARIO
if(isset($_POST['editarPerfilUsuario'])) {
	if(preg_match('/^[0-9]+$/', $_POST['idUsuarioPerfil']) &&
		preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarPerfilNombre']) &&
		preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarPerfilEmail"]) &&
		preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["emailActualPerfil"]) &&
		preg_match('/^[a-zA-Z0-9_]+$/', $_POST['editarPerfilUsuario']) &&
		preg_match('/^[a-zA-Z0-9_]+$/', $_POST['usuarioActualPerfil']) &&
		preg_match('/^[a-zA-Z0-9\s]*$/', $_POST['editarPerfilPassword']) &&
		preg_match('/^[a-zA-Z0-9.,\$\/]+$/', $_POST['passwordActualPerfil'])) {


		//NO REPETIR USUARIO 
		$item = "usuario";
		$valor = $_POST['editarPerfilUsuario'];
		$res = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		if($res) {
			if($res['usuario'] != $_POST['usuarioActualPerfil']){
				echo "Existe, nombre de usuario";
				return;
			}
		} 

		//NO REPETIR EMAIL 
		$item = "email";
		$valor = $_POST['editarPerfilEmail'];
		$res = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		if($res) {
			if($res['email'] != $_POST['emailActualPerfil']){
				echo "Existe, email";
				return;
			}
		} 
		
		//VALIDAR IMAGEN  
		if($_POST['editarPerfilUsuario'] != $_POST['usuarioActualPerfil']) {
			
			if($_POST['fotoActualPerfil'] != "") {
				$s = substr($_POST['fotoActualPerfil'], -7);

				$directorio = '../vistas/img/usuarios/'.$_POST['editarPerfilUsuario'];
				mkdir($directorio, 0755);

				copy('../'.$_POST['fotoActualPerfil'], $directorio.'/'.$s);
				unlink('../'.$_POST['fotoActualPerfil']);
				rmdir('../vistas/img/usuarios/'.$_POST['usuarioActualPerfil']);

				$directorio = substr($directorio, 3);
				$ruta = $directorio.'/'.$s;

			} else {
				$ruta = $_POST['fotoActualPerfil'];
			}
				
		} else {
			$ruta = $_POST['fotoActualPerfil'];
		}

		

		if(isset($_FILES['editarFotoPerfil']['tmp_name']) && !empty($_FILES["editarFotoPerfil"]["tmp_name"])) {
			list($ancho, $alto) = getimagesize($_FILES['editarFotoPerfil']['tmp_name']);

			$nuevoAncho = 500;
			$nuevoAlto = 500;

			$directorio = '../vistas/img/usuarios/'.$_POST['editarPerfilUsuario'];

			if(!empty($ruta)) {
				unlink('../'.$ruta);
			} else {
				mkdir($directorio, 0755);
			}

			

			if($_FILES['editarFotoPerfil']['type'] == 'image/jpeg') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/usuarios/'.$_POST['editarPerfilUsuario'].'/'.$aleatorio.'.jpg';

				$origen = imagecreatefromstring(file_get_contents($_FILES['editarFotoPerfil']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagejpeg($destino, $ruta);

				$ruta = substr($ruta, 3);
			}


			if($_FILES['editarFotoPerfil']['type'] == 'image/png') {

				$aleatorio = mt_rand(100,999);
				$ruta  = '../vistas/img/usuarios/'.$_POST['editarPerfilUsuario'].'/'.$aleatorio.'.png';

				$origen = imagecreatefromstring(file_get_contents($_FILES['editarFotoPerfil']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagepng($destino, $ruta);

				$ruta = substr($ruta, 3);
			}
		}

		$tabla = "usuarios";

		if($_POST["editarPerfilPassword"] != ""){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPerfilPassword"])){

				$encriptar = crypt($_POST["editarPerfilPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			}else{

				echo'error';

			}

		}else{

			$encriptar = $_POST["passwordActualPerfil"];

		}
		

		$datos = array("id" => $_POST['idUsuarioPerfil'],
						"nombre" => $_POST['editarPerfilNombre'],
						"email" => $_POST['editarPerfilEmail'],
						"usuario" => $_POST['editarPerfilUsuario'],
						"password" => $encriptar,
						"foto" => $ruta); 

		$respuesta = ModeloUsuarios::mdlEditarPerfilUsuario($tabla, $datos);

		if($respuesta == 'ok') {
			echo 'ok';
		}

	} else {
			echo 'error';
	}

}
