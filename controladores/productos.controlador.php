<?php

class ControladorProductos {
    
    //MOSTRAR PRODCUTOS
	static public function ctrMostrarProductos($item,$valor) {

		$tabla = 'productos';
		$respuesta = ModeloProductos::mdlMostrarProductos($tabla,$item,$valor);

		return $respuesta;


    }
    
    //ELIMINAR PRODCUTOS
	static public function ctrBorrarProducto($valor1, $valor2) {
        
		$tabla = "productos";
        $datos = $valor1;
        
        if($valor2 != "") {
            $file = '../'.$valor2;
            
            if(file_exists($file)) {
                unlink($file);
            }
        }

        $respuesta = ModeloProductos::mdlBorrarProducto($tabla, $datos);

        if($respuesta == 'ok') {
            return 'ok';
        } else {
            return 'error';
        }
		
	}
    
}