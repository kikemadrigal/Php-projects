<?php
include_once('../../config/imports.php');
$id=$_POST['id'];
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();

if(!isset($id)){
    echo "No hay clienete para mostrar";
    die();
}

if(isset($_POST['botonActualizarComando'])){
	//echo $_POST['id'].",   ".$_POST['cif'].",   ".$_POST['nombre'].",   ".$_POST['datos'];
	$actualizada=RepositorioComandos::actualizarComando($conexion,$_POST['id'],$_POST['nombre'],$_POST['datos']);
	if($actualizada){
		header("Location: ".RUTA_COMANDOS_MOSTRAR);
		die();
	}else{
		$error="El Comando no pudo actualizarse.";
	}
	
}

$comando=RepositorioComandos::mostrarUnComando($conexion, $id);
Conexion::cerrar_conexion();
iniciarDocumento();
?>

<div class="container">
   
<br><br><br>
	<h4 class="d-flex justify-content-center">Actualizar comando</h4>
	
	<div class="row d-flex justify-content-center">
		<div class="col-md-6">
			<br><br>
			<!--Cuando se le quita la ruta al action lo manda a la misma página-->
      <form method="POST" id='formularioActualizarComando' name='formularioActualizarComando' action="<?php //echo RUTA_COMANDO_ACTUALIZAR; ?>" enctype="multipart/form-data">
				<div class="form-group">
					<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $comando[nombre]; ?>" />
				</div>
				<div class="form-group">
					<textarea class="form-control" id="datos" name="datos"><?php echo $comando[datos]?></textarea>
				</div>
				<input type="hidden" id="id" name="id" value="<?php echo $id ?>">
				<div class="form-group d-flex justify-content-center">
						<input type='submit' name='botonActualizarComando' id="botonActualizarComando" value='Actualizar' class='btn btn-success m-5' />
						<a href="<?php echo RUTA_COMANDOS_MOSTRAR ?>" type="button" class="btn btn-primary m-5">Vover</a>
						<button type="button" class="btn btn-danger m-5" data-toggle="modal" data-target="#comandoModal">Eliminar</button>
				</div>
      </form>	
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php if(!empty($error)) echo "<br><div class='alert alert-danger' role='alert'>".$error."</div>"; ?>
		</div>
	</div>
</div>








<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="comandoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       ¿Estas seguro de que deseas eliminar el comando?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <a href='<?php echo RUTA_COMANDO_ElIMINAR ?>?id=<?php echo $id ?>' id="botonEliminarComando" name="botonEliminarComando" class="btn btn-primary">Si</a>
	  </div>
    </div>
  </div>
</div>
<?php

finalizarDocumento();
?>