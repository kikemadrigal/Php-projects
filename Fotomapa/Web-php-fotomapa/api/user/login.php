<?php


//Echamos al usuario que ya ha iniciado sesion
/*if(ControlSesion::comprobar_sesion_iniciada()){
	header('Location: '.RUTA_HOME);
	echo "Sesion ya iniciada-->".session_id().", <a href=".RUTA_SERVER.">Volver</a>";
	die();
}*/

Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();
$mensaje="";
//$passwordHash=password_hash($_POST['password'],PASSWORD_DEFAULT);

$usuario=RepositorioUsuario::obtener_usuario_por_email_api($conexion, $_POST['email']);
//$claveVerficada=password_verify($_POST['password'],$usuario->getClave());
$claveVerficada=password_verify($_POST['password'],$usuario['clave']);
//$mensaje=$usuario['correo'].", clave: ".$usuario['clave'];
//$mensaje="nombre. ".$usuario->getNombre().", clave: ".$usuario->getClave();

if($usuario==null || empty($usuario)){
	$mensaje.="Usuario no encontrado";
}else{
	if($claveVerficada){
		//$mensaje="email mandado: ".$_POST['email'].", email almacenado: ".$usuario->getCorreo().", password: ".$passwordHash.", password almacenado: ".$usuario->getClave();
		$mensaje.="Autorizado";
	}else{
		//$mensaje="email mandado: ".$_POST['email'].", email almacenado: ".$usuario->getCorreo().", password: ".$passwordHash.", password almacenado: ".$usuario->getClave();
		//.$passwordHash.", password almacenado: ".$usuario->getClave();
		$mensaje.="La contraseña no coincide.";
	}
}

/*$array=["nombre"=>$_POST['name'], "password"=>$_POST['password']];
$cadena=$usuario->getNombre();
echo json_encode($cadena);*/


echo json_encode($mensaje);
Conexion::cerrar_conexion();


?>