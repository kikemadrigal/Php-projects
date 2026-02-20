<?php
require_once( "app/config.php" );
require_once( "app/ControlSesion.php" );
require_once( "app/Conexion.php" );
require_once( "app/RepositorioFotos.php" );
require_once( "app/Foto.php" );


require_once('views/layouts/document-start.inc.php');

require_once('views/map/map.inc.php');
echo "<br>";

require_once('views/photos/carrusel.inc.php');

require_once('views/layouts/document-end.inc.php');
?>