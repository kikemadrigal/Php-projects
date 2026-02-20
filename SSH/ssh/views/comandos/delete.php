<?php
include_once('../../config/imports.php');
$id=$_GET['id'];
iniciarDocumento();
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
if(!isset($id)){
    echo "No hay comando para eliminar";
    die();
}else{
	$eliminadoOK=RepositorioComandos::eliminarComando($conexion, $id);
	if($eliminadoOK){
		header("Location: ".RUTA_COMANDOS_MOSTRAR);
	}else{
		$error="El comando no pudo actualizarse.";
	}
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php if(!empty($error)) echo "<br><div class='alert alert-danger' role='alert'>".$error."</div>"; ?>
			<a href="<?php echo RUTA_COMANDOS_MOSTRAR ?>" type="button" class="btn btn-primary m-5">Vover</a>
		</div>
	</div>
</div>
<?php
finalizarDocumento();
?>