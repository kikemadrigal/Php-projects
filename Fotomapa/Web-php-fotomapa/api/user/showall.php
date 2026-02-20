<?php

Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();

$array = RepositorioUsuario::getAllAPI( $conexion );

echo json_encode($array);

	
conexion::cerrar_conexion();

?>