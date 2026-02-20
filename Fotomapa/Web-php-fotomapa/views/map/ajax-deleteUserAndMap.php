<?php
	header("access-control-allow-origin: *");
	//session_start();
	require_once( "../../app/config.php" );
	require_once( "../../app/RepositorioMapConfigure.php" );
	require_once( "../../app/ControlSesion.php" );
	require_once( "../../app/Conexion.php" );
	//require_once( "../../app/MapConfigure.php" );
	require_once( "../../app/Usuario.php" );
	require_once( "../../app/RepositorioUsuario.php" );
	$insertada=false;
	if ( ControlSesion::comprobar_sesion_iniciada() ) {
			$nombreUsuario = $_SESSION[ 'nombre' ];
		} else {
			$nombreUsuario = "IP:" . $_SERVER[ 'REMOTE_ADDR' ];
		}

	if(isset($_GET)){
		Conexion::abrir_conexion();
		$conexion=Conexion::obtener_conexion();
		$borrado=RepositorioUsuario:: deleteUserFilesAndMap($conexion,$nombreUsuario);
		if(ControlSesion::comprobar_sesion_iniciada()){
			ControlSesion::cerrar_sesion();
		}
		Conexion::cerrar_conexion();
	}
	
	echo $borrado;
	




?>