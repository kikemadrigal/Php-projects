<?php
//Echamos al usuario que ya ha iniciado sesion
if(ControlSesion::comprobar_sesion_iniciada()){
	header('Location: '.RUTA_HOME);
	echo "Sesion ya iniciada-->".session_id().", <a href=".RUTA_SERVER.">Volver</a>";
	die();
}

//Si pulsa el botón se crea el validador
if ( isset( $_POST[ 'botonFormularioLogin' ] ) ) {
	Conexion::abrir_conexion();
	$validarLogin = new ValidacionesFormularioLoginUsuario( Conexion::obtener_conexion(), $_POST[ 'nombreusuario' ], $_POST[ 'claveusuario' ] );
	if($validarLogin->registroValido()){
		$usuario=RepositorioUsuario::obtener_usuario_por_nombre(Conexion::obtener_conexion(), $validarLogin->getNombre());
		if($usuario==null){
		}else{
			ControlSesion::abrir_sesion($usuario);
			Conexion::cerrar_conexion();
			echo "<script type='text/javascript'>location.href='".RUTA_HOME."'</script>";
			die();
		}
		
		//$mensaje="El ".$_SESSION['tipo'].": ".$_SESSION['nombre']." ha iniciado sesión";
		//RepositorioUserMessages::stored(Conexion::obtener_conexion(),$mensaje, $validarLogin->getNombre());
		//echo "<script type='text/javascript'>location.href='".RUTA_HOME."'</script>";
		/*echo "sesion abierta para ".$_SESSION['nombre'].", ".$_SESSION['tipo'];
		if(ControlSesion::comprobar_sesion_iniciada())
			{
				echo "<br>sesion iniciada"; 
			}else{
				echo "sesion no iniciada"; 
			}*/
		
	}
}



//Cabecera html
include_once( "views/layouts/document-start.inc.php" );
?>

<div class="container">
	<br><br>
	<?php
	if(!isset($_POST['botonFormularioLogin'])){
		//echo "<h3>El boto no existe</h3>";
		include('loginempty.inc.php');
	}else{
		//echo "<h3>El boto si existe</h3>";
		include('loginvalidate.inc.php');
	}
	?>
	
</div>
<?php
//Final html
include_once( "views/layouts/document-end.inc.php" );
?>