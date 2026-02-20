<?php
	header("access-control-allow-origin: *");
	require_once('../../app/config.php');
	require_once( "../../app/RepositorioFotos.php" );
	require_once( "../../app/ControlSesion.php" );
	require_once( "../../app/Conexion.php" );
	require_once( "../../app/Foto.php" );
	
	$nombreUsuario='';
	if ( ControlSesion::comprobar_sesion_iniciada() ) {
		$nombreUsuario = $_SESSION[ 'nombre' ];
	} else {
		$nombreUsuario = "IP:" . $_SERVER[ 'REMOTE_ADDR' ];
	}
	Conexion::abrir_conexion();
	$foros=array();
	$fotos=RepositorioFotos::getAllArrayUser(Conexion::obtener_conexion(),ControlSesion::getNameUsuario());
	echo json_encode($fotos);
	Conexion::cerrar_conexion();
?>