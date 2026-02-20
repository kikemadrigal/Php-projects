<?php 
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$actualizada=RepositorioComandos::actualizarComando($conexion,$_POST['id'],$_POST['nombre'],$_POST['datos']);
if($actualizada){
	$response="Comando actualizado";
}else{
	$response="Comando no actualizado";
}
Conexion::cerrar_conexion();
echo json_encode($response);
?> 