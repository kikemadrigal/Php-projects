<?php 
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$actualizada=RepositorioClientes::actualizarCliente($conexion,$_POST['id'],$_POST['cif'],$_POST['nombre'],$_POST['datos']);
if($actualizada){
	$mensaje="Cliente actualizado";
}else{
	$mensaje="Cliente no actualizado";
}
Conexion::cerrar_conexion();
echo json_encode($mensaje);
?> 