<?php
	header("access-control-allow-origin: *");
	session_start();
	require_once( "../../app/config.php" );
	require_once( "../../app/RepositorioMapConfigure.php" );
	require_once( "../../app/ControlSesion.php" );
	require_once( "../../app/Conexion.php" );
	require_once( "../../app/MapConfigure.php" );
	$existe=0;
	if ( ControlSesion::comprobar_sesion_iniciada() ) {
			$nombreUsuario = $_SESSION[ 'nombre' ];
		} else {
			$nombreUsuario = "IP:" . $_SERVER[ 'REMOTE_ADDR' ];
		}


	Conexion::abrir_conexion();
	$conexion=Conexion::obtener_conexion();
	$idMapa=RepositorioMapConfigure::getIdMapaDeUnUsuario($conexion, $nombreUsuario);
	$localizacionPermitida=RepositorioMapConfigure::getLoalizacionPermitidaMapaDeUnUsuario($conexion, $idMapa);
	echo json_encode($localizacionPermitida);




?>