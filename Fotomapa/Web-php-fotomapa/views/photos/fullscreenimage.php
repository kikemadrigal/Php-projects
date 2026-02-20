<?php
//Para las rutas
require_once("app/config.php");
//Necesitamos una conexión a la base de datos
require_once("app/Conexion.php");
require_once( "app/ControlSesion.php" );
//Necesitamos trabajar con el modelo Fotos
require_once("app/RepositorioFotos.php");
//Necesitamos la clase Foto
require_once("app/Foto.php");
require_once('app/ObtenerUsuario.php');
if(!isset($idFoto)){
	echo "<script type='text/javascript'>location.href='http://fotomurcia.tipolisto.es'</script>";
} 
Conexion::abrir_conexion();
$foto=RepositorioFotos::show(Conexion::obtener_conexion(),$idFoto);
Conexion::cerrar_conexion();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Foto pantalla completa</title>
</head>
<style type="text/css">
    html, body {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
    }
 
    #full-screen-background-image {
        z-index: -999;
        width: 100%;
        height: auto;
        /*position: fixed;*/
        top: 0;
        left: 0;
    }
</style>
	
	
<body><img src='../../resources/imagesusers/<?php echo $foto->getUser()."/".$foto->getName(); ?>' id="full-screen-background-image"></img>

</body>
</html>

