<?php
//Necesitamos una conexión a la base de datos
require_once( "app/Conexion.php" );
//Necesitamos trabajar con el modelo Fotos
require_once( "app/RepositorioFotos.php" );
require_once("app/RepositorioUserMessages.php");
//Necesitamos la clase Foto
require_once( "app/Foto.php" );
//Para las rutas
require_once( "app/config.php" );

Conexion::abrir_conexion();
if(!empty($idFoto)){
	//echo "<h1>el id es: ".$idFoto."</h1>";
	$foto = RepositorioFotos::show( Conexion::obtener_conexion(), $idFoto );
	//echo "<h1>Nombre: ".$foto->getType()."</h1>";
}



if ( isset( $_POST[ 'buttonFormularioDeletePhoto' ] ) ) {
	$foto = RepositorioFotos::show( Conexion::obtener_conexion(), $_POST[ 'id' ] );
	$fueBorrada=RepositorioFotos::delete(Conexion::obtener_conexion(), $foto->getId());
	if($fueBorrada){
		//header('Location: http://fotomurcia.tipolisto.es/views/photos/showall.php');
		RepositorioUserMessages::stored(Conexion::obtener_conexion(),"Foto: ".$foto->getName()." borrada!!", $foto->getUser());
		echo "<script type='text/javascript'>location.href='".RUTA_GESTOR_FOTOS_USUARIO."';</script>";
		die();
	}else{
		$mensaje="La foto ".$foto->getName(). " no pudo borrarse.";
	}	
}
Conexion::cerrar_conexion();
include_once( "views/layouts/document-start.inc.php" );
?>
<br><br><br>
<div class="container">
	<!--well well bs-component -->
	<div class="row">
		<div class="col-md-12">
			<img src='../../resources/imagesusers/<?php echo $foto->getUser()."/".$foto->getName(); ?>' class="img-fluid" alt="Responsive image">
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<p>¿Seguro que desea borrar	<?php echo $foto->getName(); ?></p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<form method="POST" id='formularioVerFoto' name='formularioVerFoto' action="<?php echo RUTA_BORRAR_FOTO; ?>">
				<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $foto->getId();?>">
				<div class='form-group'>
					<div class='col-md-6 col-md-offset-2'>
						<input type="submit" id="buttonFormularioDeletePhoto" name="buttonFormularioDeletePhoto" class="btn btn-danger btn-large" value="Borrar">
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php if(!empty($mensaje)) echo "<br><div class='alert alert-danger' role='alert'>".$mensaje."</div>"; ?>
		</div>
	</div>
</div>
<?php
include_once( "views/layouts/document-end.inc.php" );
?>