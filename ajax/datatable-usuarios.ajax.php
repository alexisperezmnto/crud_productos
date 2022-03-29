<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class TablaUsuarios{

	//MOSTRAR LA TABLA DE USUARIOS
	public function mostrarTablaUsuarios(){

		$item = null;
    	$valor = null;

  		$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);	
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($usuarios); $i++){

		  	if($usuarios[$i]["foto"] != '') {
	            $foto =  "<img src='".$usuarios[$i]['foto']."' class='centrarElemento img-thumbnail' width='40px'>";
			} else {
	            $foto = "<img src='vistas/img/usuarios/default/anonymous.png' class='centrarElemento img-thumbnail' width='40px'>";
			}

			if($usuarios[$i]['usuario'] == 'admin') {
				$estado = "<button class='btn btn-success btn-xs centrarElemento' disabled>Activado</button>";
			} else if($usuarios[$i]['estado'] != 0) {
	            $estado = "<button class='btn btn-success btn-xs centrarElemento btnActivar' idUsuario='".$usuarios[$i]['id']."'  estadoUsuario='0'>Activado</button>";
			} else {
				$estado = "<button class='btn btn-danger btn-xs centrarElemento btnActivar' idUsuario='".$usuarios[$i]['id']."'  estadoUsuario='1'>Desactivado</button>";
			}
			
			if($_SESSION['usuario'] != 'admin' && $usuarios[$i]['usuario'] == 'admin') {
				$accion = "<i class='fa fa-pen mr-2' style='cursor:not-allowed'></i>".
				"<i class='fa fa-trash' style='cursor:not-allowed'></i>"; 
			} else if($usuarios[$i]['usuario'] == 'admin') {
				$accion = "<i class='fa fa-pen mr-2 btnEditarUsuario' idUsuario='".$usuarios[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUsuario' style='cursor:pointer'></i>".
				"<i class='fa fa-trash' style='cursor:not-allowed'></i>"; 
			} else {
				$accion = "<i class='fa fa-pen mr-2 btnEditarUsuario' idUsuario='".$usuarios[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUsuario' style='cursor:pointer'></i>".
				"<i class='fa fa-trash btnEliminarUsuario' idUsuario='".$usuarios[$i]["id"]."' fotoUsuario='".$usuarios[$i]['foto']."' usuario='".$usuarios[$i]['usuario']."' style='cursor:pointer'></i>"; 
			}

	    	$datosJson .='[
		      "'.$usuarios[$i]["nombre"].'",
		      "'.$usuarios[$i]["email"].'",
		      "'.$usuarios[$i]["usuario"].'",
		      "'.$foto.'",
		      "'.$usuarios[$i]["perfil"].'",
		      "'.$estado.'",
		      "'.$accion.'"
		    ],';

		  }

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;


	}

}


$usuarios = new TablausUarios();
$usuarios -> mostrarTablaUsuarios();

