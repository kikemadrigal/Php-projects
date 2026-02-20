<?php
//Necesitamos una conexión a la base de datos
require_once("app/Conexion.php");
//Necesitamos trabajar con el modelo Fotos
require_once("app/RepositorioFotos.php");
require_once("app/RepositorioUserMessages.php");
//Necesitamos la clase Foto
require_once("app/Foto.php");
//Para las rutas
require_once("app/config.php");
require_once("app/RepositorioUsuario.php");
require_once("app/ObtenerUsuario.php");
Conexion::abrir_conexion();
//1.Obtenemos el tipo de usuario y si no es administrador lo echamos
$tipoDeUsuario=RepositorioUsuario::obtener_tipo_por_nombre(Conexion::obtener_conexion(),ObtenerUsuario::get());
if($tipoDeUsuario!=='administrador'){
	$mensaje = "Página no encontrada";
	echo "<script type='text/javascript'>location.href='http://fotomurcia.tipolisto.es/404.php'</script>";
	die();
}
if(isset($idFoto)){
	//2.El administrador la valida, es decir en el campo validada le pone 10
	$actualizada=RepositorioFotos::actualizarValidacionFoto(Conexion::obtener_conexion(),$idFoto);
	if($actualizada){
		//3.Si se ha validado lo mandamos de nuevo a ver las fotos no validadas de anónimos
		$mensaje = "Foto validada!!!.";
		RepositorioUserMessages::stored(Conexion::obtener_conexion(),$mensaje, $nombreUsuario);
		echo "<script type='text/javascript'>location.href='".RUTA_VER_NO_VALIDADAS_DE_ANONIMOS."'</script>";
		die();
	}
}
Conexion::cerrar_conexion();
?>