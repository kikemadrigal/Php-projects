<?php
	header("access-control-allow-origin: *");
	session_start();
	require_once( "../../app/config.php" );
	require_once( "../../app/RepositorioMapConfigure.php" );
	require_once( "../../app/ControlSesion.php" );
	require_once( "../../app/Conexion.php" );
	require_once( "../../app/MapConfigure.php" );
	$existe=false;
	
	Conexion::abrir_conexion();
	$conexion=Conexion::obtener_conexion();
	$arrayMapa=array();
	$map=RepositorioMapConfigure::getMapaDeUnUsuario($conexion, ControlSesion::getNameUsuario());
	if($map!=null){
		$arrayMapa = array( "id" => $map->getId(),"locationAllow"=>$map->getLocationAllow(), "latPosition" => $map->getLatPosition(), "lngPosition"=>$map->getLngPosition(), "zoom"=>$map->getZoom(),"type"=> $map->getType(), "minMarkers"=>$map->getMinMArkers(), "maxMarkers"=>$map->getMaxMarkers(), "timeStamp"=>$map->getTimeStamp(), "IdUSer"=>$map->getIdUser() );
	}
	echo json_encode($arrayMapa);
?>