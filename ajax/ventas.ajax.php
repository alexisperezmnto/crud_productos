<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxVentas {
	public $usuario;
	public $productos;
	public $total;

	//GUARDAR VENTA
	public function ajaxGuardarVenta() {

		$datos = array(
			"usuario" => $this->usuario,
			"productos" => $this->productos,
			"total" => $this->total
		);

		$respuesta = ControladorVentas::ctrGuardarVenta($datos);

		if($respuesta == 'ok') {
			echo 'ok';
		}
	}

	//MOSTRAR VENTA
	public $idVenta;

	public function mostrarVenta() {
		$item = 'id';
		$valor = $this->idVenta;
		$respuesta = ControladorVentas::ctrMostrarVentas($item, $valor);

		echo json_encode($respuesta);
	}

	//PRODUCTO MAYOR STOCK
	public function productoMayorStock() {
		$respuesta = ControladorVentas::ctrProductoMayorStock();

		echo json_encode($respuesta);
	}

	//PRODUCTO MÁS VENDIDO
	public function productoMasVendido() {
		$respuesta = ControladorVentas::ctrProductoMasVendido();

		echo json_encode($respuesta);
	}

}


//GUARDAR VENTA
if(isset($_POST['productos'])) {
	$venta = new AjaxVentas();
	$venta -> usuario = $_POST['usuario'];
	$venta -> productos = $_POST['productos'];
	$venta -> total = $_POST['total'];
	$venta -> ajaxGuardarVenta();
}

//MOSTRAR VENTA
if(isset($_POST['idVenta'])) {
	$venta = new AjaxVentas();
	$venta -> idVenta = $_POST['idVenta'];
	$venta -> mostrarVenta();
}

//PRODUCTO MAYOR STOCK
if(isset($_POST['mayorStock'])) {
	$venta = new AjaxVentas();
	$venta -> productoMayorStock();
}

//PRODUCTO MÁS VENDIDO
if(isset($_POST['masVendido'])) {
	$venta = new AjaxVentas();
	$venta -> productoMasVendido();
}
