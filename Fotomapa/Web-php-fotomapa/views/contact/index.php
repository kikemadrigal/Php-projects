<?php
require_once('app/config.php');
//require_once('../../model/Conexion.php');
//require_once('../../model/RepositorioFotos.php');
//require_once('../../model/Foto.php');
$titulo = " Contacta - Fotomapa.es";
$mensaje="";
if ( isset( $_POST[ 'botonFormularioMandarCorreo' ] ) ) {
		/*************PARTE DE CAPTCHA****************************/
		// Creamos el captacha para verificar que no soy un robot
		require_once("views/layouts/lib/recaptchalib.php");
		$response = null;
		$reCaptcha = new ReCaptcha(CLAVE_CAPTCHA);
		if ($_POST["g-recaptcha-response"]) {
			$response = $reCaptcha->verifyResponse(
				$_SERVER["REMOTE_ADDR"],
				$_POST["g-recaptcha-response"]
			);
		}
		if ($response == null && !$response->success) {
			$mensaje = "Eres un robot";
			echo "<script type='text/javascript'>location.href='https://fotomapa.es/404'</script>";
			die();
		} 
		/****************FIN DE PARTE DE CAPTCHA********************/
		$to = "adm@fotomurcia.tipolisto.es";
		$subject = $_POST['nombre'];
		$txt = "<html> <head> <title>fotomapa.es</title> </head> <body><p>".$_POST['texto']."</p></body></html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: adm@fotomapa.es" . "\r\n" .
				"CC: ";
		mail($to,$subject,$txt,$headers);
		$mensaje="Mensaje enviado.";
}
include_once("views/layouts/document-start.inc.php");	
?>
	<br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p>Hola soy Chus, el administrador de esta web</p>
				<p>Si quieres ponerte en contacto conmigo, puedes mandarme un mensaje al correo:
				adm@fotomapa.es o escribir algo en el formulario que aparece más abajo (que también me envía un correo).
				</p>
			</div>
		</div>
		<div class="col-md-8">
			<form method="POST" id='formularioMandarCorreo' name='formularioMandarCorreo' action="<?php echo RUTA_CONTACTA; ?>">
				<div class="form-group">
					<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe tu nombre" required>
				</div>
				<div class="form-group">
					<textarea type="text" class="form-control" id="texto" name="texto" placeholder="Texto" rows="3" required></textarea>
				</div>
				<div class="g-recaptcha" data-sitekey="6LeXZUIUAAAAAErFjwGRhCrr6F2hAqKH7mP4edVN"></div>
				<br>
				<input type="submit" class="btn btn-primary btn-lg btn-block" id='botonFormularioMandarCorreo' name='botonFormularioMandarCorreo' value="Enviar correo">
				</input>
			</form>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php if(!empty($mensaje)) echo "<br><div class='alert alert-danger' role='alert'>".$mensaje."</div>"; ?>
			</div>
		</div>
		
	</div>

	<?php
include_once("views/layouts/document-end.inc.php");
?>