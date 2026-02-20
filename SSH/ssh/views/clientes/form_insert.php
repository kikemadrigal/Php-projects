
<?php
include_once('../../config/imports.php');
if ( isset( $_POST[ 'botonFormularioInsertarCliente' ] ) ) {
    Conexion::abrir_conexion();
    $conexion=Conexion::obtener_conexion();
    $insertado=RepositorioClientes::crearCliente($conexion, $_POST['cif'], $_POST['nombre'], $_POST['datos']);
	if ($insertado) {
		header("Location: ".RUTA_CLIENTES_MOSTRAR);
		die();
	} 
}
iniciarDocumento();
?>
<br>
<br>
<br>
<h4 class="d-flex justify-content-center">Crear cliente</h4>
<br><br><br>
<div class="row d-flex justify-content-center">
	<div class="col-md-6">
		<form method="POST" id='formularioInsertarCliente' name='formularioInsertarCliente' action="<?php echo RUTA_CLIENTE_NUEVO; ?>" enctype="multipart/form-data">
			<div class="form-group">
				<!-- aceptaremos cualquier carácter independientemente de la nacionalidad, con una tamaño entre 2 y 64 caracteres.-->
				<input type="text" class="form-control" id="cif" name="cif" placeholder="cif" pattern="{2,64}" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="datos" name="datos" placeholder="datos">
			</div>
			<div class="form-group d-flex justify-content-center">
				<input type="submit" class="btn btn-primary btn btn-success m-5" id='botonFormularioInsertarCliente' name='botonFormularioInsertarCliente' value="crear cliente">
				<a href="<?php echo RUTA_CLIENTES_MOSTRAR ?>" type="button" class="btn btn-primary m-5">Vover</a>	
			</div>
			
			</button>
		</form>
	</div>
</div>
<?php
finalizarDocumento();
?>
    
