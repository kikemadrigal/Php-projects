<?php
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$comandos=RepositorioComandos::obtenerTodosLosComandos($conexion);
Conexion::cerrar_conexion();

echo json_encode($comandos);
?>