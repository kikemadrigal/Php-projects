<?php 
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$eliminadoOK=RepositorioComandos::eliminarComando($conexion, $_GET['id']);
if($eliminadoOK){
	$response="Comando eliminado";
}else{
	$response="Comando no eliminado";
}
Conexion::cerrar_conexion();
echo json_encode($response);
?>