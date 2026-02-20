
<?php
require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ControlSesion.php" );
require_once("app/RepositorioFotos.php");
//Necesitamos la clase Foto
require_once("app/Foto.php");
require_once( "app/RepositorioUsuario.php" );
require_once( "app/ObtenerUsuario.php" );

if(!isset($idFoto)){
	echo "<script type='text/javascript'>location.href='http://fotomurcia.tipolisto.es'</script>";
} 
Conexion::abrir_conexion();
//$foto=RepositorioFotos::show(Conexion::obtener_conexion(),$_GET['id']);
//El id es mandado desde el enrutador /index.php
$foto=RepositorioFotos::show(Conexion::obtener_conexion(),$idFoto);
Conexion::cerrar_conexion();
include_once("views/layouts/document-start.inc.php");
if($foto==null|| empty($foto)) echo "<div class='container'><br><br><br>No se obtuvo ninguna foto de ".$id."</div>";
else{
//print_r($foto);
?>
<script type="application/ld+json">
  "@context": "http://schema.org",
  "@type": "ImageObject",
  "author": "<?php echo $foto->getUser();?>",
  "contentLocation": "<?php echo $foto->getAddress();?>, <?php echo $foto->getCity();?>, <?php echo $foto->getCountry();?>",
  "contentUrl": "<?php echo $foto->getName();?>",
  "datePublished": "<?php echo $foto->getTimeStamp();?>",
  "description": "<?php echo $foto->getText();?>",
  "name": "<?php echo $foto->getName();?>"
</script>
<br><br><br>
<div class="container">
	<!--well well bs-component -->
	<div class="row">
		<div class="col-md-4">
				<div class="form-group">
					<input type="text" class="form-control" id="type" name="type" placeholder="Título vacío" value="<?php echo $foto->getType();?>" disabled>
				</div>
				<div class="form-group">
					<textarea type="text" class="form-control" id="text" name="text" placeholder="Texto vacío" rows="3" disabled><?php echo $foto->getText(); ?></textarea>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="address" name="address" placeholder="Dirección: vacía" value="<?php echo $foto->getAddress();?>" disabled>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="city" name="city" placeholder="Ciudad:  vacía" value="<?php echo $foto->getCity();?>" disabled>
				</div>

				<?php
				//Menu creador de la foto
				Conexion::abrir_conexion();
				if(RepositorioFotos::obtenerCreadorDeFotoConId(Conexion::obtener_conexion(),$foto->getId())===ObtenerUsuario::get()){
					?>
					<p>Eres el creador de esta foto.</p>
					<form method="post" action="<?php echo RUTA_EDITAR_FOTO; ?> " style="display: inline">
						<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
						<button type='submit' name='editarFoto' class='btn btn-success btn-sm'>Editar</button>
					</form>
					&nbsp;&nbsp;&nbsp;
					<form method="post" action="<?php echo RUTA_BORRAR_FOTO; ?> "  style="display: inline">
						<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
						<button type='submit' name='editarFoto' class='btn btn-danger btn-sm'>Borrar</button>
					</form>
					<?php
				}else if(ObtenerUsuario::get()==='admin'){
					//Si eres el administrador
					?>
					<p>Eres administrador</p>
					<form method="post" action="<?php echo RUTA_EDITAR_FOTO; ?> " style="display: inline">
						<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
						<button type='submit' name='editarFoto' class='btn btn-success btn-sm'>Editar</button>
					</form>
					&nbsp;&nbsp;&nbsp;
					<form method="post" action="<?php echo RUTA_BORRAR_FOTO; ?> "  style="display: inline">
						<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
						<button type='submit' name='editarFoto' class='btn btn-danger btn-sm'>Borrar</button>
					</form>
					<?php
				}
				?>
			
		</div>
		<div class="col-md-8">
		<p><?php echo $foto->getName(); ?></p>
		
			<a href="<?php echo RUTA_FOTO_PANTALLA_COMPLETA; ?>/<?php echo $foto->getId(); ?>"><img src='../../resources/imagesusers/<?php echo $foto->getUser()."/".$foto->getName(); ?>' class="img-fluid" alt="Responsive image"></a>
			<br>
			<p>Pincha para ponerla a pantalla completa</p>
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
				<?php echo $foto->getLat(); ?>
			</p>
			<p><i class="fa fa-map-marker" aria-hidden="true"></i> Longitud:
				<?php echo $foto->getLng(); ?>
			</p>
			<p><i class="fa fa-user-o" aria-hidden="true"></i> Usuario:
				<?php echo $foto->getUser(); ?>
			</p>
			<p><i class="fa fa-clock-o" aria-hidden="true"></i> Fecha:
				<?php echo $foto->getTimeStamp(); ?>
			</p>
		</div>
	</div>
</div>
<?php
}
include_once("views/layouts/document-end.inc.php");
?>