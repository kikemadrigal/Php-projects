<?php
include_once('../../config/imports.php');
$id=$_POST['id'];
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();

if(!isset($id)){
    echo "No hay clienete para mostrar";
    die();
}

if(isset($_POST['botonActualizarCliente'])){
	//echo $_POST['id'].",   ".$_POST['cif'].",   ".$_POST['nombre'].",   ".$_POST['datos'];
	$actualizada=RepositorioClientes::actualizarCliente($conexion,$_POST['id'],$_POST['cif'],$_POST['nombre'],$_POST['datos']);
	if($actualizada){
		//echo "<script type='text/javascript'>location.href='".RUTA_CLIENTES_MOSTRAR."';</script>";
		header("Location: ".RUTA_CLIENTES_MOSTRAR);
		die();
	}else{
		$error="El cliente no pudo actualizarse.";
	}
}
$cliente=RepositorioClientes::mostrarUnCliente($conexion, $id);
Conexion::cerrar_conexion();
iniciarDocumento();
?>

<div class="container">
   
<br><br><br>
	<h4 class="d-flex justify-content-center">Actualizar cliente</h4>
	
	<div class="row d-flex justify-content-center">
		<div class="col-md-6">
			<br><br>
			<!--Cuando se le quita la ruta al action lo manda a la misma página-->
      <form method="POST" id='formularioActualizarCliente' name='formularioActualizarCliente' action="<?php //echo RUTA_CLIENTE_ACTUALIZAR; ?>" enctype="multipart/form-data">
				<div class="form-group">
					<input type="text" class="form-control" id="cif" name="cif" placeholder="cif" value="<?php echo $cliente[cif]; ?>" pattern="{2,64}" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $cliente[nombre]; ?>" />
				</div>
				<div class="form-group">
					<textarea class="form-control" id="datos" name="datos"><?php echo $cliente[datos]?></textarea>
				</div>
				<input type="hidden" id="id" name="id" value="<?php echo $id ?>">
				<div class="form-group d-flex justify-content-center">
						<input type='submit' name='botonActualizarCliente' id='botonActualizarCliente' value='Guardar' class='btn btn-success m-5' />
						<a href="<?php echo RUTA_CLIENTES_MOSTRAR ?>" type="button" class="btn btn-primary m-5">Vover</a>
						<button type="button" class="btn btn-danger m-5" data-toggle="modal" data-target="#clienteModal">Eliminar</button>
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











<!-- Modal -->
<div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       ¿Estas seguro de que deseas eliminar el cliente?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <a href='<?php echo RUTA_CLIENTE_ElIMINAR ?>?id=<?php echo $id ?>' id="botonEliminarCliente" name="botonEliminarCliente" class="btn btn-primary">Si</a>
	  </div>
    </div>
  </div>
</div>
<?php

finalizarDocumento();
?>