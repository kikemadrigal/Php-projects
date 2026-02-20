<?php
include_once('../../config/importsApi.php');

Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();

$clientes=RepositorioClientes::obtenerTodosLosClientes($conexion);
echo json_encode($clientes);


Conexion::cerrar_conexion();

?>