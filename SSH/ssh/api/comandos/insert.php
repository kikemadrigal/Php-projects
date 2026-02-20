
<?php 
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$insertado=RepositorioComandos::crearComando($conexion, $_POST['nombre'], $_POST['datos']);
if ($insertado) {
	$response="Comando insertado.";
} else {
	$response="Comando no insertado.";
}
echo json_encode($response);
Conexion::cerrar_conexion();
?>
    
