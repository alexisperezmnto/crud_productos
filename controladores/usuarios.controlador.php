<?php

session_start();

class ControladorUsuarios {

	//INGRESO DE USUARIO
	static public function ctrIngresoUsuario($usuario, $password) { 
        if(preg_match('/^[a-zA-Z0-9_]+$/',$usuario) && 
            preg_match('/^[a-zA-Z0-9]+$/', $password)) {

                $encriptar = crypt($password,'$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                
                $tabla = "usuarios";
                $item = "usuario";
                $valor = $usuario;
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);

                if($respuesta && $respuesta["usuario"] == $usuario && $respuesta["password"] == $encriptar) {
                    if($respuesta['estado'] == 1) {

                        $_SESSION['iniciarSesion'] = 'ok';
                        $_SESSION['id'] = $respuesta['id'];
                        $_SESSION['nombre'] = $respuesta['nombre'];
                        $_SESSION['usuario'] = $respuesta['usuario'];
                        $_SESSION['foto'] = $respuesta['foto'];
                        $_SESSION['perfil'] = $respuesta['perfil'];

                        echo 'ok';

                    } else {
                        echo 'no activo';
                    }

                } else {
                    echo 'error';
                }
        } else {
            echo 'error';
        }
	}

	//MOSTRAR USUARIO
	static public function ctrMostrarUsuarios($item,$valor) {

		$tabla = 'usuarios';
		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);

		return $respuesta;


	}

	//ELIMINAR USUARIO
	static public function ctrBorrarUsuario($valor1, $valor2, $valor3) {

		$tabla = 'usuarios';
		$item = 'id';
		$resp = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor1);

		if($resp['usuario'] != 'admin') {

			$tabla = "usuarios";
			$datos = $valor1;

			if($valor2 != "") {
				unlink('../'.$valor2);
				rmdir('../vistas/img/usuarios/'.$valor3);
			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == 'ok') {
				return 'ok';
			} else {
				return 'error';
			}

		} else {
			return 'error2';
		}
		
	}
}