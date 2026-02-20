<?php
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$comandosDeUnCliente=RepositorioClientesComandos::mostrarLosClientesComandosConNombreDeUnCliente($conexion, $_GET['id']);
Conexion::cerrar_conexion();
echo json_encode($comandosDeUnCliente);

?>