<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class TablaProductos{

	//MOSTRAR TABLA PRODUCTOS
	public function mostrarTablaProductos(){
		
		$item = null;
		$valor = null;
		$productos = ControladorProductos::ctrMostrarProductos($item, $valor);

		if(count($productos) > 0) {

			$datosJson = '{
			"data": [';

			for($i = 0; $i < count($productos); $i++){


				//Imagen
				if($productos[$i]["imagen"] != '') {
					$imagen =  "<img src='".$productos[$i]['imagen']."' class='img-thumbnail' width='40px'>";
				} else {
					$imagen = '';
				}
				
				//Categoría
				$item = "id";
				$valor = $productos[$i]["categoria"];

				$categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);

				//Acciones
				$accion = "<i class='fa fa-pen mr-3 btnEditarProducto' idProducto='".$productos[$i]["id"]."' style='cursor: pointer'></i>".
				"<fa class='fa fa-trash btnEliminarProducto' idProducto='".$productos[$i]["id"]."' imagenProducto='".$productos[$i]['imagen']."' style='cursor: pointer'></fa>"; 


				$datosJson .='[
					"'.$productos[$i]["id"].'",
					"'.$imagen.'",
					"'.$productos[$i]["nombre"].'",
					"'.$productos[$i]["referencia"].'",
					"$'.$productos[$i]["precio"].'",
					"'.$productos[$i]["peso"].'",
					"'.$categoria["nombre"].'",
					"'.$productos[$i]["stock"].'",
					"'.$accion.'"
				],';

			}

			$datosJson = substr($datosJson, 0, -1);

			$datosJson .=   '] 

			}';
			
			echo $datosJson;
		
		} else {

			$datosJson = '{"data":[["","","","","","","","",""]]}';

			echo $datosJson;
		}
	}

}


$productos = new TablaProductos();
$productos -> mostrarTablaProductos();

