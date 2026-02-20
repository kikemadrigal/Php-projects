<?php
require_once('app/ControlSesion.php');
class ObtenerUsuario{
	function __construct(){}
	public static function get(){
		$nombreUsuario='';
		if ( ControlSesion::comprobar_sesion_iniciada() ) {
			$nombreUsuario = $_SESSION[ 'nombre' ];
			//echo "<h1>nombre: </h1>-->".$_SESSION[ 'nombre' ];
		} else {
			$nombreUsuario = "IP:" . $_SERVER[ 'REMOTE_ADDR' ];
			//echo "<h1>nombre ip: </h1>".$_SESSION[ 'nombre' ];
		}
		return $nombreUsuario;
	}
}



?>