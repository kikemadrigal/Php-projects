<?php
//Archivos necesarios para trabajar:
require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ValidacionesFormularioNuevoUsuario.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/RepositorioUserResetPassword.php" );
require_once( "app/Usuario.php" );
//Si pulsa el botón se crea el validador
if ( isset( $_POST[ 'botonResetPaswoord' ] ) ) {
	Conexion::abrir_conexion();
		$existeEmail=RepositorioUsuario::comprobarSiExisteEmail(Conexion::obtener_conexion(), $_POST['correousuario']);
		$usuario=RepositorioUsuario::obtener_usuario_por_email(Conexion::obtener_conexion(), $_POST['correousuario']);
		if($existeEmail){
			$codigoActivacion=RepositorioUsuario::generarCodigoActivacion(20,false);
			RepositorioUserResetPassword::stored(Conexion::obtener_conexion(),$codigoActivacion,$usuario->getId());
			$to = $usuario->getCorreo();
			$subject = "Restablece tu clave en FotoMurcia.";
			$txt = "<html> <head> <title>FotoMurcia.es</title> </head> <body><p>Usuario: ".$usuario->getNombre()."</p><p><a href=http://fotomurcia.tipolisto.es/user/loginresetpassword/".$codigoActivacion.">Sigue este enlace para cambiar tu clave en FotoMurcia</a></p></body></html>";
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers .= "From: adm@FotoMurcia.tipolisto.es" . "\r\n" .
				"CC: ";
			mail($to,$subject,$txt,$headers);
		}
	Conexion::cerrar_conexion();
}





//Cabecera html
include_once( "views/layouts/document-start.inc.php" );
//Barra de navegacion
include_once( "views/layouts/navbar.inc.php" );
?>
<br><br><br>
<div class="container">
	<form name="lostpasswordform" id="lostpasswordform" action="<?php echo RUTA_OLVIDO_CLAVE; ?>" method="post" class='form-horizontal'>
		<div class='form-group'>
			<label for="correousuario" class='sr-only'>Correo:</label>
			<div class='col-md-6'>
				<input type="email" class="form-control" name="correousuario" id="correousuario" placeholder="Correo:" required>
			</div>
		</div>
		<div class='form-group'>
			<div class='col-md-6 col-md-offset-2'>
				<input type="submit" class="btn btn-primary btn-large" id="botonResetPaswoord" name="botonResetPaswoord" value="Obtener una contrase&ntilde;a nueva"/>
			</div>
		</div>
	</form> 
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
		<?php
			if( isset( $_POST[ 'botonResetPaswoord' ] )){
				
				if($existeEmail){
					echo "<p>Mensaje enviado al correo: ".$usuario->getCorreo().", por favor revisa en el correo spam y el correo no deseado</p>";
				}else{
					echo "<p>No existe este correo".$usuario->getCorreo()."</p>";
				}
			}
		?>
		</div>
	</div>
</div>
<?php
include_once( "views/layouts/document-end.inc.php" );
?>