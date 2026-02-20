<?php

Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();

$array = RepositorioFotos::getAllAPI( $conexion,1000 );

echo json_encode($array);
//echo var_dump($array);
	
conexion::cerrar_conexion();

?>