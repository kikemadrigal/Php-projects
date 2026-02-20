<?php
class ControlSesion{
	public static function abrir_sesion($usuario){
		if(session_id()==''){
			session_start();
		}
		$_SESSION['nombre']=$usuario->getNombre();
		$_SESSION['tipo']=$usuario->getTipo();
		$_SESSION['id']=$usuario->getId();
	}
	public static function cerrar_sesion(){
		if(session_id()==''){
			session_start();
		}
		if(isset($_SESSION['nombre'])){
			unset($_SESSION['nombre']);
		}
		if(isset($_SESSION['tipo'])){
			unset($_SESSION['tipo']);
		}

		if(session_id()=='' || session_id()==null){
			return true;
		}else{
			return false;
		}
	}
	public static function comprobar_sesion_iniciada(){
		if(session_id()==''){
			session_start();
		}
		if(isset($_SESSION['nombre']) && isset($_SESSION['tipo'])){
			return true;
		}else{
			return false;
		}
	}
	
	public static function getIdUsuario($conexion){
		$idUsuario=null;
		//require_once('RepositorioUsuario.php');
		if ( ControlSesion::comprobar_sesion_iniciada() ) {
			$nombreUsuario = $_SESSION[ 'nombre' ];
		} else {
			$nombreUsuario = "IP:" . $_SERVER[ 'REMOTE_ADDR' ];
		}
		$usuarioEstaCreado=RepositorioUsuario::comprobarSiExisteNombre( $conexion, $nombreUsuario );
		if($usuarioEstaCreado){
			//Si el usuario está ya creado obtenemos su id
			$idUsuario=RepositorioUsuario::obtener_id_usuario_por_nombre($conexion,$nombreUsuario);
		}else{
			//Si no está creado el usuario creamos uno
			//__construct($id,$nombre,$clave,$tipo,$correo,$nombreReal,$apellidos,$web,$validado,$contador)
			$usuario=new Usuario("",$nombreUsuario,password_hash("UNO", PASSWORD_DEFAULT), "usuariosinregistrar","","","","",0,0);
			RepositorioUsuario::stored($conexion,$usuario);
			$idUsuario=$conexion->lastInsertId();
		}
		return $idUsuario;
	}


	public static function getNameUsuario(){
		$nombreUsuario=null;
		if ( ControlSesion::comprobar_sesion_iniciada() ) {
			$nombreUsuario = $_SESSION[ 'nombre' ];
		} else {
			$nombreUsuario="Sin nombre porque no has iniciado sesión";
			//$nombreUsuario = "IP:" . $_SERVER[ 'REMOTE_ADDR' ];
		}
		return $nombreUsuario;
	}
}


?>