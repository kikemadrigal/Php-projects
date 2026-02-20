<?php
require_once('app/config.php');
require_once( "app/RepositorioFotos.php" );
require_once( "app/ControlSesion.php" );
require_once( "app/Conexion.php" );
require_once( "app/Foto.php" );

$titulo ="Mapa";
include_once( "views/layouts/document-start.inc.php" );


//Llamamos al archivo que contiene el mapa
include_once( "views/map/map.inc.php" );

include_once( "views/layouts/document-end.inc.php" );


?>