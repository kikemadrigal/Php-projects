<?php
	//Content-type: application/json
	header("access-control-allow-origin: *");
	require_once('../../app/config.php');
	require_once( "../../app/RepositorioFotos.php" );
	//require_once( "../../app/ControlSesion.php" );
	require_once( "../../app/Conexion.php" );
	//require_once( "../../app/Foto.php" );
	Conexion::abrir_conexion();
	$foros=array();
	//echo "<h1>Marcadores maximos: ".$_GET['maxMarkers']."</h1>";
	$fotos=RepositorioFotos::getAllArray(Conexion::obtener_conexion(), $_GET['maxMarkers']);
	if($fotos!=null){
		echo json_encode($fotos);	
	}
?>