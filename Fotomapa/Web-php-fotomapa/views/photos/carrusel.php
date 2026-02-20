<?php
$titulo ="Carrusel de fotos";
//Para las rutas
require_once( "app/config.php" );
//Necesitamos una conexión a la base de datos
require_once( "app/Conexion.php" );
//Necesitamos trabajar con el modelo Fotos
require_once( "app/RepositorioFotos.php" );
//Necesitamos trabajar con la Foto
require_once( "app/Foto.php" );




include_once("views/layouts/document-start.inc.php");
//Llamamos al archivo que contiene el carrusel
include_once("views/photos/carrusel.inc.php");
include_once("views/layouts/document-end.inc.php");
?>