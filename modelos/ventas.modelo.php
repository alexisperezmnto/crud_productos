<?php

require_once "conexion.php";

class ModeloVentas {
    
    //MOSTRAR VENTAS
    static public function mdlMostrarVentas($tabla, $item, $valor) {
        if($item != null) {
            $stmt = Conexion::conectar()->prepare("
                SELECT p.nombre, p.imagen, p.referencia, p.precio, pv.cantidad cantidad FROM $tabla v 
                INNER JOIN productos_vendidos pv ON (v.id = pv.id_venta) 
                INNER JOIN productos p ON (pv.id_producto = p.id) 
                WHERE v.id = :valor
            ");
			$stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");
			$stmt->execute();
			return $stmt->fetchAll();
		}

		$stmt -> close();
		$stmt = null;
    }

    //GUARDAR VENTA
    static public function mdlGuardarVenta($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(total, id_usuario) VALUES (:total, :id_usuario)");
        $stmt->bindParam(":total", $datos['total'], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $datos['usuario'], PDO::PARAM_STR);

        if($stmt->execute()) {
            $query = Conexion::conectar()->query("SELECT id FROM ventas ORDER BY id DESC LIMIT 1");
            $lastId = $query->fetch();
            return $lastId['id'];
        } else {
            return 'error';
        }
    }

    //GUARDAR PRODUCTOS VENTA
    static public function mdlGuardarProductosVenta($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_venta, id_producto, cantidad) VALUES (:id_venta, :id_producto, :cantidad)");
        $stmt->bindParam(":id_venta", $datos['idVenta'], PDO::PARAM_STR);
        $stmt->bindParam(":id_producto", $datos['idProducto'], PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $datos['cantidad'], PDO::PARAM_STR);

        if($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
    }

    //PRODUCTO CON MAYOR STOCK
    static public function mdlProductoMayorStock($tabla) {
        $query = Conexion::conectar()->query("SELECT nombre, stock FROM $tabla ORDER BY stock DESC LIMIT 1");
        return $query->fetch();
    }

    //PRODUCTO MÁS VENDIDO
    static public function mdlProductoMasVendido() {
        $query = Conexion::conectar()->query("
            SELECT p.nombre, SUM(cantidad) cantidad FROM productos_vendidos pv 
            INNER JOIN productos p ON (p.id = pv.id_producto ) 
            GROUP BY pv.id_producto 
            ORDER BY cantidad DESC 
            LIMIT 1;
        ");
        return $query->fetch();
    }
}