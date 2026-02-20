<?php
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$cliente=RepositorioClientes::mostrarUnCliente($conexion, $_GET['id']);
Conexion::cerrar_conexion();
echo json_encode($cliente);
?>