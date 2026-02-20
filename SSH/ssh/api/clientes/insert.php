
<?php
include_once('../../config/importsApi.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$insertado=RepositorioClientes::crearCliente($conexion, $_POST['cif'], $_POST['nombre'], $_POST['datos']);

if ($insertado) {
	$mensaje="Cliente insertado";
} else{
	$mensaje="Cliente no insertado";
}
//$mensaje=$_POST['cif'].", ".$_POST['nombre'].", ".$_POST['datos'];

Conexion::cerrar_conexion();
echo json_encode($mensaje);

?>
    
