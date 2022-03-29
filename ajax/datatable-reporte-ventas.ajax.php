<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaVentas{

	//MOSTRAR TABLA VENTAS
	public function mostrarTablaVentas(){
		
		$item = null;
		$valor = null;
		$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

		if(count($ventas) > 0) {

			$datosJson = '{
			"data": [';

			for($i = 0; $i < count($ventas); $i++){

				//Fecha
				$fecha = new DateTime($ventas[$i]["fecha"]);
				$fecha = $fecha->format('d/m/Y'); 

				//Usuario
				$item = 'id';
				$valor = $ventas[$i]['id_usuario'];
				$usuario = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
				
				if(!$usuario) {
					$usuario['nombre'] = '';
				}

				//Acciones
				$accion = "<i class='fa fa-eye detalleVenta' idVenta='".$ventas[$i]["id"]."' fecha='".$fecha."' usuario='".$usuario["nombre"]."' total='".$ventas[$i]["total"]."' style='cursor:pointer;'></i>"; 

				$datosJson .='[
					"'.$ventas[$i]["id"].'",
					"'.$fecha.'",
					"'.$usuario["nombre"].'",
					"$'.$ventas[$i]["total"].'",
					"'.$accion.'"
				],';

			}

			$datosJson = substr($datosJson, 0, -1);

			$datosJson .=   '] 

			}';
			
			echo $datosJson;
		
		} else {

			$datosJson = '{"data":[["","","","",""]]}';

			echo $datosJson;
		}
	}

}


$ventas = new TablaVentas();
$ventas -> mostrarTablaVentas();

