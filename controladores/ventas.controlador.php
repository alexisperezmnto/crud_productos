<?php

class ControladorVentas {
    
    //MOSTRAR VENTAS
    static public function ctrMostrarVentas($item, $valor) {
        $tabla = 'ventas';
		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

		return $respuesta;
    }

    //GUARDAR VENTA
    static public function ctrGuardarVenta($datos) {
        if(isset($datos['productos'])) {

            //STOCK
            require_once "../controladores/productos.controlador.php";
            require_once "../modelos/productos.modelo.php";

            $productos = json_decode($datos['productos'], true);
            
            //Verificar stock
            $actualizarStock = true;
            foreach($productos as $key => $value) {
                $item = "id";
                $valor = $value['id'];
                $producto = ControladorProductos::ctrMostrarProductos($item, $valor);

                $nuevoStock = $producto['stock'] - $value['cantidad'];
                
                if($nuevoStock < 0) {
                    $actualizarStock = false;
                    break;
                } 
            }
            
            //Actualizar stock
            if($actualizarStock) {
                foreach($productos as $key => $value) {
                    $item = "id";
                    $valor = $value['id'];
                    $producto = ControladorProductos::ctrMostrarProductos($item, $valor);
    
                    $nuevoStock = $producto['stock'] - $value['cantidad'];
                    
                    $tabla = 'productos';
                    $stock = ModeloProductos::mdlActualizarStock($tabla, $nuevoStock, $item, $valor);
                }
            } else {
                echo 'stock';
                return;
            }

            //Guardar venta
            $tabla = 'ventas';
            $respuesta = ModeloVentas::mdlGuardarVenta($tabla, $datos);

            //Guardar productos
            if($respuesta != 'error') {

                $idVenta = $respuesta;

                foreach($productos as $key => $value) {

                    $tabla = 'productos_vendidos';

                    $datos = array(
                        "idVenta" => $idVenta,
                        "idProducto" => $value['id'],
                        "cantidad" => $value['cantidad']
                    );

                    $producto = ModeloVentas::mdlGuardarProductosVenta($tabla, $datos);
                }

                echo 'ok';
            } else {
                echo 'error';
            }
        }
    }

    //PRODUCTO CON MAYOR STOCK
    static public function ctrProductoMayorStock() {
        $tabla = 'productos';
		$respuesta = ModeloVentas::mdlProductoMayorStock($tabla);

		return $respuesta;
    }

    //PRODUCTO MÁS VENDIDO
    static public function ctrProductoMasVendido() {
		$respuesta = ModeloVentas::mdlProductoMasVendido();

		return $respuesta;
    }
}
