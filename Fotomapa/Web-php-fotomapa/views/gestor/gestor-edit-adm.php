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
require_once( "app/ObtenerUsuario.php" );
//Obtenemos el tipo de usuario
Conexion::abrir_conexion();
$tipoDeUsuario=RepositorioUsuario::obtener_tipo_por_nombre(Conexion::obtener_conexion(),ObtenerUsuario::get());
if($tipoDeUsuario!=='administrador'){
	echo "<script type='text/javascript'>location.href='http://fotomurcia.tipolisto.es/404.php'</script>";
	die();
}


if(isset($_POST['botonGuardarEditarFoto'])){
	$foto=new Foto($_POST['id'],$_POST['name'],$_POST['text'],$_POST['type'],$_POST['address'],$_POST['city'],$_POST['country'],$_POST['lat'],$_POST['lng'],$_POST['user'],$_POST['validada'],$_POST['timestamp']);
	$actualizada=RepositorioFotos::actualizarFoto(Conexion::obtener_conexion(),$foto);
	//echo "<h2>-->".$actualizada."</h2>";
	if($actualizada){
		//RepositorioUserMessages::stored(Conexion::obtener_conexion(),"Foto: ".$foto->getName()." actualizada!!", $foto->getUser());
		echo "<script type='text/javascript'>location.href='".RUTA_GESTOR_FOTOS_VER_TODAS_ADM."';</script>";
		die();
	}else{
		$error="La foto ".$foto->getName(). " no pudo actualizarse.";
	}	
	
}elseif($idFoto==null){
	echo "No se obtuvo ninguna foto de ".$idFoto;
}else{

$foto=RepositorioFotos::show(Conexion::obtener_conexion(),$idFoto);
Conexion::cerrar_conexion();	

include_once("views/layouts/document-start.inc.php");
?>
<br><br><br>
<div class="container">
	<!--well well bs-component -->
	<div class="row">
		<div class="col-md-4">
			<form method="POST" id='formularioVerFoto' name='formularioVerFoto' action="<?php echo RUTA_GESTOR_FOTOS_EDITAR_ADM; ?>" enctype="multipart/form-data">
				<div class="form-group">
					<input type="text" class="form-control" id="type" name="type" placeholder="Tipo vacío" value="<?php echo $foto->getType();?>">
				</div>
				<div class="form-group">
					<textarea type="text" class="form-control" id="text" name="text" placeholder="Texto vacío" rows="3"><?php echo $foto->getText(); ?></textarea>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="address" name="address" placeholder="Dirección: vacía" value="<?php echo $foto->getAddress();?>" >
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="city" name="city" placeholder="Ciudad:  vacía" value="<?php echo $foto->getCity();?>">
				</div>
				<input type="hidden" name="id" value="<?php echo $foto->getId(); ?>">
				<input type="hidden" name="name" value="<?php echo $foto->getName(); ?>">
				<input type="hidden" name="city" value="<?php echo $foto->getCity(); ?>">
				<input type="hidden" name="lat" value="<?php echo $foto->getLat(); ?>">
				<input type="hidden" name="lng" value="<?php echo $foto->getLng(); ?>">
				<input type="hidden" name="user" value="<?php echo $foto->getUser(); ?>">
				<input type="hidden" name="validada" value="<?php echo $foto->getValidada(); ?>">
				<input type="hidden" name="timeStamp" value="<?php echo $foto->getTimeStamp(); ?>">
				<input type='submit' name='botonGuardarEditarFoto' value='Guardar' class='btn btn-success btn-sm'></input>
			</form>
		</div>
		<div class="col-md-8">
		<p><?php echo $foto->getUser()."/".$foto->getName(); ?></p>
		
			<img src='../../resources/imagesusers/<?php echo $foto->getUser()."/foto/".$foto->getName(); ?>' class="img-fluid" alt="Responsive image">


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
include_once("views/layouts/document-end.inc.php");
}//Fi del else si no hay foto
?>