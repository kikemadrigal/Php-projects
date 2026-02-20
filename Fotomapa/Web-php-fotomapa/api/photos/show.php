
<?php

/*
if(!isset($idFoto)){
	echo "<script type='text/javascript'>location.href='http://fotomurcia.tipolisto.es'</script>";
} */
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$foto=RepositorioFotos::showAPI($conexion,$idFoto);
echo json_encode($foto);
Conexion::cerrar_conexion();
?>