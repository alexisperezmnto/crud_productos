<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class AjaxProductos {
	
	//EDITAR PRODUCTOS
	public $idProducto;

	public function ajaxEditarProducto() {

		$item = "id";
		$valor = $this->idProducto;
		$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);

		echo json_encode($respuesta);

	}

	//ELIMINAR PRODUCTOS
	public $eliminarProducto;
	public $imagenProducto;

	public function ajaxEliminarProducto() {
		$valor1 = $this->eliminarProducto;
		$valor2 = $this->imagenProducto;
		$respuesta = ControladorProductos::ctrBorrarProducto($valor1, $valor2);

		echo json_encode($respuesta);
	}

}


//EDITAR PRODUCTOS
if(isset($_POST['idProducto'])) {
	$editar = new AjaxProductos();
	$editar -> idProducto = $_POST['idProducto'];
	$editar -> ajaxEditarProducto();
}

//ELIMINAR PRODUCTOS
if(isset($_POST['eliminarProducto'])) {
	
	$eliminarProducto = new AjaxProductos();
	$eliminarProducto -> eliminarProducto = $_POST['eliminarProducto'];
	$eliminarProducto -> imagenProducto = $_POST['imagenProducto'];
	$eliminarProducto -> ajaxEliminarProducto();
}

