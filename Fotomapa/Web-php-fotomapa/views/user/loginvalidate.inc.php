<form name="loginform" class='form-horizontal' id="loginform" action="<?php echo RUTA_LOGIN;?>" method="post">
	<div class='form-group'>
		<label for="nombreusuario" class='sr-only'>Nombre de usuario</label>
		<div class='col-md-6'>
			<input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title='Se necesita un nombre' placeholder="Nombre:" <?php echo $validarLogin->mostrarNombre();?> />
		</div>
		<?php echo $validarLogin->mostrarErrorNombre()?>
	</div>
	<div class='form-group'>
		<label for="claveusuario" class='sr-only'>Contrase&ntilde;a</label>
		<div class='col-md-6'>
			<input type="password" class="form-control" name="claveusuario" id="claveusuario" title='Se necesita una clave' placeholder="Contrase&ntilde;a:" />
		</div>
		<?php echo $validarLogin->mostrarErrorClave()?>
	</div>
	<input type="hidden" name="accion" id="accion" value="controlUsuarios"/>
	<div class='form-group'>
		<div class='col-md-2 col-md-offset-2'>
			<input type="submit" class="btn btn-primary btn-large" id='botonFormularioLogin' name='botonFormularioLogin' value="Acceder"/>
		</div>
	</div>

</form>