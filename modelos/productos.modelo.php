<?php

require_once 'conexion.php';

class ModeloProductos {

	//MOSTRAR PRODCUTOS
	static public function mdlMostrarProductos($tabla, $item, $valor) {

		if($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();	
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}
		
		$stmt -> close();
		$stmt = null;
    }
    
	//REGISTRO PRODCUTOS
	static public function mdlRegistrarProducto($tabla, $datos) {
		$stmt = Conexion::conectar() -> prepare("INSERT INTO $tabla(nombre,imagen,referencia,precio,peso,categoria,stock)	
            VALUES (:nombre,:imagen,:referencia,:precio,:peso,:categoria,:stock)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":referencia", $datos["referencia"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
		$stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);

		if($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
    }
    
	//EDITAR PRODCUTOS
	static public function mdlEditarProducto($tabla, $datos) {
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
			nombre = :nombre, imagen = :imagen, referencia = :referencia, precio = :precio, peso = :peso, 
			categoria = :categoria, stock = :stock WHERE id = :id");

			$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
			$stmt->bindParam(":referencia", $datos["referencia"], PDO::PARAM_STR);
			$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
			$stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
			$stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
			$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
			$stmt->bindParam(":id", $datos["id_producto"], PDO::PARAM_INT);

		if($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
    }
    
	//ELIMINAR PRODCUTOS
	static public function mdlBorrarProducto($tabla, $datos) {
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	//ACTUALIZAR STOCK
	static public function mdlActualizarStock($tabla, $datos, $item, $valor) {
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = :stock WHERE $item = :valor");
		$stmt->bindParam(':stock', $datos, PDO::PARAM_STR);
		$stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
		
		if($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}
}