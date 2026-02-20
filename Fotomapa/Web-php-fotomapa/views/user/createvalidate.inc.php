	<form class='form-horizontal' name="registerform" id="registerform" method="post" action="<?php echo RUTA_REGISTRO; ?>">
		<div class='form-group'>
			<label for="nombreusuario" class='sr-only'>Usuario</label>
			<div class='col-md-6'>
				<!--Este input tiene la validación PHP (ValidacionesFormularioNuevoUsuario.php)-->
				<input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title='El nombre debe de contener entre 4 y 15 letras o números sin espacios' placeholder="Nombre:" <?php $userValidador->mostrarNombre();?>>
			</div>
			<?php echo $userValidador->mostrarErrorNombre(); ?>
			<!--<div id="respuestaComprobarNombreUsuario" class='alert alert-danger' role='alert'></div>-->
		</div>
		<div class='form-group'>
			<label for="correousuario" class='sr-only'>Correo:</label>
			<div class='col-md-6'>
				<!--Este input tiene la validación PHP-->
				<input type="email" class="form-control" name="correousuario" id="correousuario" placeholder="Correo:" <?php $userValidador->mostrarEmail();?>>
			</div>
			<?php echo $userValidador->mostrarErrorEmail(); ?>
			<!--<div id="respuestaComprobarCorreoUsuario" class='alert alert-danger' role='alert'></div>-->
		</div>
		<div class='form-group'>
			<label for='claveusuario1' class='sr-only'>Contrase&ntilde;a nueva</label>
			<div class='col-md-6'>
				<!--Este input tiene la validación PHP-->
				<input type='password' class='form-control' id='claveusuario1' name='claveusuario1' title='Minimo 5 caracteres, máximo 15' placeholder="Contrase&ntilde;a:">
			</div>
			<?php echo $userValidador->mostrarErrorClave1(); ?>
		</div>
		<div class='form-group'>
			<label for='claveusuario2' class='sr-only'>Repita la nueva contrase&ntilde;a:</label>
			<div class='col-md-6'>
				<!--Este input tiene la validación PHP-->
				<input type='password' class='form-control' id='claveusuario2' name='claveusuario2' title='Minimo 5 caracteres, máximo 15' placeholder="Repite contrase&ntilde;a:">
			</div>
			<?php echo $userValidador->mostrarErrorClave2(); ?>
			<!--<div id="respuestaComprobarClavesIguales" class='alert alert-danger' role='alert'></div>-->
		</div>
		<div class="g-recaptcha" data-sitekey="6LeXZUIUAAAAAErFjwGRhCrr6F2hAqKH7mP4edVN"></div>
		<br>
		<div class='form-group'>
			<div class='col-md-6 col-md-offset-2'>
				<input type="submit" id="buttonEnviarFormularioCreateUser" name="buttonEnviarFormularioCreateUser" class="button btn-primary btn-large" >
			</div>
		</div>
	</form>