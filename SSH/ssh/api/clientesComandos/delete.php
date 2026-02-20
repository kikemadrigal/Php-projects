<?php
include_once('../../config/importsApi.php');
//$mensaje="El id es ".$_POST['id'];
//echo json_encode($mensaje);
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$borrada=RepositorioClientesComandos::eliminarClientesComando($conexion,$_POST['id'] );
if($borrada){
    $response="Comando borrado";
}else{
    $response="El comando no pudo borrarse al cliente";
}

Conexion::cerrar_conexion();
echo json_encode($response);

?>