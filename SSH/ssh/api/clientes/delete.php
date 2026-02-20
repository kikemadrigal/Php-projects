<?php
include_once('../../config/importsApi.php');

Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();

$eliminadoOK=RepositorioClientes::eliminarCliente($conexion,$_GET['id']);
if($eliminadoOK){
	$mensaje="Cliente eliminado";
}else{
	$mensaje="Cliente no eliminado";
}
Conexion::cerrar_conexion();
echo json_encode($mensaje);
?>