<?php
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();

$actualizada=RepositorioClientesComandos::crearClientesComando($conexion,$_POST['idCliente'],$_POST['idComando']);
if($actualizada){
    $response="Cliente comando añadido";
}else{
    $response="El cliente comando no pudo añadirse al cliente.";
}
Conexion::cerrar_conexion();
echo json_encode($response);
?>