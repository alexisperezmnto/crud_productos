<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class inicioSesion {

    public $usuario;
    public $password;

    public function iniciarSesion() {

        $usuario = $this->usuario;
        $password = $this->password;

        $respuesta = ControladorUsuarios::ctrIngresoUsuario($usuario, $password);
        
    }

}

if(isset($_POST['usuario'])) {
		
    $sesion = new inicioSesion();
    $sesion -> usuario = $_POST['usuario'];
    $sesion -> password = $_POST['password'];
    $sesion -> iniciarSesion();
}