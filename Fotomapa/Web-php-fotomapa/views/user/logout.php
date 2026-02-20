<?php
session_start();
require_once('app/ControlSesion.php');
require_once('app/config.php');
require_once('app/Conexion.php');
require_once( "app/RepositorioUserMessages.php");
Conexion::abrir_conexion();
if(ControlSesion::comprobar_sesion_iniciada()){
	$sesioncerrada=ControlSesion::cerrar_sesion();
	echo "<script type='text/javascript'>location.href='".RUTA_HOME."'</script>";
}
Conexion::cerrar_conexion();
?>