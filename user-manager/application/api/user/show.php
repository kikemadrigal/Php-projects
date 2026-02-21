<?php

Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$usuario=Users::obtener_usuario_por_id($conexion,$id_usuario);
//En la base de datos están los usuario 11,12,14,15
//echo "Usuario: ".$usuario->getNombre().", ".$usuario->getId();
$usuarioJson= json_encode($usuario);
echo $usuarioJson;
Conexion::cerrar_conexion();

?>