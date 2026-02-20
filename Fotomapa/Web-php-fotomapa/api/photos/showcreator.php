



<?php
//echo "has entrado";
require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ControlSesion.php" );
require_once( "app/RepositorioFotos.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/ObtenerUsuario.php" );


Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();

$nombre = Repositoriousuario::obtener_nombre_de_usuario_por_id( $conexion, 22 );

echo json_encode($nombre);
//echo $nombre;
	
conexion::cerrar_conexion();

?>