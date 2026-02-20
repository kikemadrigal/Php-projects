<?php
require_once( "app/config.php" );
require_once( "app/ControlSesion.php" );
require_once( "app/Conexion.php" );

require_once( "app/Foto.php" );
require_once( "app/Usuario.php" );
require_once( "app/RepositorioFotos.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/RepositorioUserMessages.php");

require_once( "app/Archivo.php" );
// Creamos el captacha para verificar que no soy un robot
require_once("views/layouts/lib/recaptchalib.php");
//variables globales
$error = ""; //esta variable solo sirve para mostrar los errores.
$fecha = date( "d-m-Y" );
$hora = date( "H-i-s" );
//$nombreUsuario = "";


//Si se ha enviado el formulario
if ( isset( $_POST[ 'botonFormularioInsertarFoto' ] ) ) {
	/*************PARTE DE CAPTCHA****************************/
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
		$mensaje = "Eres un robot";
		echo "<script type='text/javascript'>location.href='https://fotomapa.es/404'</script>";
		die();
	} 
	/****************FIN DE PARTE DE CAPTCHA********************/
	//1.Comprobamos si hay una foto
	if ( !empty( $_FILES[ 'archivofoto' ][ 'name' ] ) ) {
		$nombreArchivoFoto = $_FILES[ 'archivofoto' ][ 'name' ];
		$tipoArchivo = $_FILES[ 'archivofoto' ][ 'type' ];
		$tamanoArchivo = $_FILES[ 'archivofoto' ][ 'size' ];
		//2.Comprobamos la extión y el tamaño del archivo foto
		if ( !( strpos( $tipoArchivo, "gif" ) || strpos( $tipoArchivo, "jpeg" ) || strpos( $tipoArchivo, "jpg" ) || strpos( $tipoArchivo, "png" ) || $tamanoArchivo > 900000 ) ) {
			$error = "La foto no tiene el formato o el tama&ntilde;o correcto, solo se aceptan, jpg , gif o png menores de 90Mb.<br />";
		} else {
			Conexion::abrir_conexion();
			$conexion=Conexion::obtener_conexion();
			//Subimos el archivo
			//En el constructor de Archivo pasamos el archivo, el nombre del archivo y el nombre de usuario
			//construct($archivo,$nombreArchivo,$idUsuario,$fecha)
			$archivo = new Archivo( $_FILES[ 'archivofoto' ][ 'tmp_name' ], $_FILES[ 'archivofoto' ][ 'name' ], ControlSesion::getIdUsuario($conexion),$fecha."-".$hora);
			$fotosubida = $archivo->subirArchivo();
			if ( $fotosubida ) {
				$idUsuario=null;
				//geIdUsuario devuelve un id si no exite lo crea nuevo y te lo devuelve
				$idUsuario=ControlSesion::getIdUsuario($conexion);
				//__construct($id, $name, $text, $type, $address, $city, $country, $lat, $lng, $user,$validada, $timestamp)
				$foto = new Foto( '', $fecha."-".$hora."-".$nombreArchivoFoto, $_POST[ 'text' ], $_POST[ 'type' ], $_POST[ 'address' ], $_POST[ 'city' ], $_POST[ 'country' ], $_POST[ 'lat' ], $_POST[ 'lng' ], $idUsuario,0, $fecha . " a las " . $hora );
				$fotoInsertada = RepositorioFotos::stored( $conexion, $foto );		
				if ( $fotoInsertada ) {
					$mensaje = "Imagen " . $nombreArchivoFoto . " subida!!!.";
					echo "<script type='text/javascript'>location.href='".RUTA_SERVER."'</script>";
					die();
				} else {
					$error = "No se pudo insertar la foto en la base de datos " . $nombreArchivoFoto;
				}
			} else {
				$error = "No se puede subir el archivo " . $nombreArchivoFoto;
			}
			Conexion::cerrar_conexion();
		}
	} else {
		echo "No ha foto para subir.";
	}

}





include_once( "views/layouts/document-start.inc.php" );
?>

<br>
<div class="container">
	<!--well well bs-component -->
	<div class="row">
		<div class="col-md-6">
			<form method="POST" id='formularioInsertarFoto' name='formularioInsertarFoto' action="<?php echo RUTA_CREAR_FOTO; ?>" enctype="multipart/form-data">
				<div class="form-group">
					<input type="file" class="form-control" id="archivofoto" name="archivofoto" required>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="type" name="type" placeholder="Título: (opcional)">
				</div>
				<div class="form-group" style="background-color: white;">

					<textarea class="form-control" id="text" name="text" placeholder="Texto (opcional)"></textarea>
					<!--<textarea id="text" name="text" style="background-color: white;" rows="30"></textarea>-->

				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="address" name="address" placeholder="Dirección: (opcional)">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="city" name="city" placeholder="Ciudad: (opcional)">
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control" id="country" name="country" placeholder="Ciudad: (opcional)">
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control" id="lat" name="lat" value="<?php echo $lat; ?>">
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control" id="lng" name="lng" value="<?php echo $lng; ?>">
				</div>
				<div class="g-recaptcha" data-sitekey="6LeXZUIUAAAAAErFjwGRhCrr6F2hAqKH7mP4edVN"></div>
				<br>
				<input type="submit" class="btn btn-primary btn-lg btn-block" id='botonFormularioInsertarFoto' name='botonFormularioInsertarFoto' value="Enviar">
				</button>
			</form>
		</div>
		<div class="col-md-6">
			<output id="list"></output>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php if(!empty($error)) echo "<br><div class='alert alert-danger' role='alert'>".$error."</div>"; ?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<p><i class="fa fa-address-book" aria-hidden="true"></i> Otros datos:
			</p>
			<p><i class="fa fa-map-marker" aria-hidden="true"></i> Latitud:
				<?php echo $lat;?>
			</p>
			<p><i class="fa fa-map-marker" aria-hidden="true"></i> Longitud:
				<?php echo $lng;?>
			</p>
			<p><i class="fa fa-user-o" aria-hidden="true"></i> Usuario:
				<?php echo $nombreUsuario; ?>
			</p>
			<p><i class="fa fa-clock-o" aria-hidden="true"></i> Fecha:
				<?php echo $fecha." a las ".$hora ?>
			</p>
		</div>
	</div>
</div>

<script>
	function archivo( evt ) {
		var files = evt.target.files; // FileList object

		// Obtenemos la imagen del campo "file".
		for ( var i = 0, f; f = files[ i ]; i++ ) {
			//Solo admitimos imágenes.
			if ( !f.type.match( 'image.*' ) ) {
				continue;
			}

			var reader = new FileReader();

			reader.onload = ( function ( theFile ) {
				return function ( e ) {
					// Insertamos la imagen
					document.getElementById( "list" ).innerHTML = [ '<img style="height: 300px;border: 1px solid #000;margin: 10px 5px 0 0;" src="', e.target.result, '" title="', escape( theFile.name ), '"/>' ].join( '' );
				};
			} )( f );

			reader.readAsDataURL( f );
		}
	}

	document.getElementById( 'archivofoto' ).addEventListener( 'change', archivo, false );
</script>

<?php
include_once( "views/layouts/document-end.inc.php" );
?>