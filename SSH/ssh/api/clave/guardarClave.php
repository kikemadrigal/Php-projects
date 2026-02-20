<?php 
$clavePublica=$_POST['archivo'];

//$ruta="./resources/files/";
$nombre_archivo = "../../files/authorized_keys"; 

//$ruta_archivo=$ruta.$nombre_archivo;
/*if(file_exists($nombre_archivo))
{
	$mensaje = "El Archivo $nombre_archivo existe.";
}

else
{
	$mensaje = "El Archivo $nombre_archivo no existe";
}*/

if($archivo = fopen($nombre_archivo, "w"))
{
	if(fwrite($archivo,$clavePublica))
	{
		$mensaje ="Se ha creado el archivo $nombre_archivo y se ha introducido el texto $clavePublica";
	}
	else
	{
		$mensaje= "Ha habido un problema al crear el archivo";
	}

	fclose($archivo);
}
//$mensaje="Estas en guardar  clave";
function mostrarPermisos($archivo){
	$permisos = fileperms($archivo);

	switch ($perms & 0xF000) {
		case 0xC000: // Socket
			$info = 's';
			break;
		case 0xA000: // Enlace simbólico
			$info = 'l';
			break;
		case 0x8000: // Normal
			$info = 'r';
			break;
		case 0x6000: // Bloque especial
			$info = 'b';
			break;
		case 0x4000: // Directorio
			$info = 'd';
			break;
		case 0x2000: // Carácter especial
			$info = 'c';
			break;
		case 0x1000: // Tubería FIFO pipe
			$info = 'p';
			break;
		default: // Desconocido
			$info = 'u';
	}
	
	// Propietario
	/*$info .= (($permisos & 0x0100) ? 'r' : '-');
	$info .= (($permisos & 0x0080) ? 'w' : '-');
	$info .= (($permisos & 0x0040) ?
				(($permisos & 0x0800) ? 's' : 'x' ) :
				(($permisos & 0x0800) ? 'S' : '-'));*/

	if($permisos & 0x0100){
		$permisoLectura=true;
	}else{
		$permisoLectura=false;
	}

	if(($permisos & 0x0080)){
		$permisoEscritura=true;
	}else{
		$permisoEscritura=false;
	}
	
	// Grupo
	/*$info .= (($permisos & 0x0020) ? 'r' : '-');
	$info .= (($permisos & 0x0010) ? 'w' : '-');
	$info .= (($permisos & 0x0008) ?
				(($permisos & 0x0400) ? 's' : 'x' ) :
				(($permisos & 0x0400) ? 'S' : '-'));*/



	if($permisos & 0x0020){
		$permisoLectura=true;
	}else{
		$permisoLectura=false;
	}
	if($permisos & 0x0010){
		$permisoEscritura=true;
	}else{
		$permisoEscritura=false;
	}
	
	// Mundo
	/*$info .= (($permisos & 0x0004) ? 'r' : '-');
	$info .= (($permisos & 0x0002) ? 'w' : '-');
	$info .= (($permisos & 0x0001) ?
				(($permisos & 0x0200) ? 't' : 'x' ) :
				(($permisos & 0x0200) ? 'T' : '-'));*/

	if($permisos & 0x0004){
		$permisoLectura=true;
	}else{
		$permisoEscritura=false;
	}

	if($permisos & 0x0002){
		$permisoEscritura=true;
	}else{
		$permisoEscritura=false;
	}

	if(!$permisoLectura || !$permisoEscritura){
		return $mensajePermisos="Faltan";
	}else{
		return $mensajePermisos="Bien";
	}

	
	//return $info;
}
//le evolveremos faltan si no podemos leer o escribir en el archivo
echo json_encode (mostrarPermisos($nombre_archivo));

?>