<?php
//Archivos necesarios para trabajar:
require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ValidacionesFormularioNuevoUsuario.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/Usuario.php" );

if ( isset( $_POST[ 'buttonEnviarFormularioCreateUser' ] ) ) {
	/*************PARTE DE CAPTCHA****************************/
	// Creamos el captacha para verificar que no soy un robot
	require_once("views/layouts/lib/recaptchalib.php");
	$response = null;
	$reCaptcha = new ReCaptcha(CLAVE_CAPTCHA);
	 // if submitted check response
	if ($_POST["g-recaptcha-response"]) {
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}
	if ($response == null && !$response->success) {
		//$mensaje = "Eres un robot";
		echo "<script type='text/javascript'>location.href='https://fotomapa.es/404'</script>";
		die();
	} 
	/****************FIN DE PARTE DE CAPTCHA********************/
	Conexion::abrir_conexion();
	$userValidador = new ValidacionesFormularioNuevoUsuario(Conexion::obtener_conexion(),$_POST[ 'nombreusuario' ], $_POST[ 'correousuario' ], $_POST[ 'claveusuario1' ], $_POST[ 'claveusuario2' ] );
	if($userValidador->registroValido()){
		$usuario=new Usuario('',$userValidador->getNombre(),password_hash($userValidador->getClave1(), PASSWORD_DEFAULT),'usuario', $userValidador->getEmail(), 'nada','nada','nada','0','0',date('Y-m-d'),$userValidador->getClave1());
		$insertadoUsuario=RepositorioUsuario::stored(Conexion::obtener_conexion(),$usuario);
		//echo "<h1>----------------->".$insertadoUsuario."</h1>";
		//echo "<h1>----------------->".RUTA_REGISTRO_CORRECTO.'?nombre='.$usuario->getNombre()."</h1>";
		if($insertadoUsuario){
			//1.parametro la direccion, 2. si queremos que se reescriba la dirección, 3. El código de lo que estamos haciendo,301 indica redirección
			//header ('Location: '.RUTA_REGISTRO_CORRECTO.'?nombre='.$usuario->getNombre(), true, 301);
			//! and 1 envía header por su cuenta impidiendo la redirección por cabeceras de php
			$ruta=RUTA_REGISTRO_CORRECTO.'/'.$usuario->getNombre();
			echo "<script type='text/javascript'>location.href='$ruta';</script>";
			die();
		}else{
			echo "No se pudo crear el nuevo usuario";
		}
	}
	Conexion::cerrar_conexion();
}
//Cabecera html
include_once( "views/layouts/document-start.inc.php" );
//Barra de navegacion
include_once( "views/layouts/navbar.inc.php" );
?>
<br>
<div class="container">
	<?php
	if ( isset( $_POST[ 'buttonEnviarFormularioCreateUser' ] ) ) {
		include('createvalidate.inc.php');
	}else{
		include('createempty.inc.php');
	}
	?>
	<!--con $_SERVER['PHP_SELF'] obtenemos el nombre del archivo actual-->
	<p>Recibirás un correo electr&oacute;nico.</p>
	<br/>
	<p>
		<a href="<?php echo RUTA_LOGIN; ?>" title="Acceder">Acceder</a> |
		<a href="<?php echo RUTA_OLVIDO_CLAVE; ?>" title="Recupera tu contrase&ntilde;a perdida">¿Has perdido tu contrase&ntilde;a?</a>
	</p>
	<p><a href="<?php echo RUTA_HOME; ?>" title="¿Te has perdido?">Volver a FotoMurcia</a>
	</p>
</div>
<?php
//Final html
include_once( "views/layouts/document-end.inc.php" );
?>