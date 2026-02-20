<!--
	Formulario vacío para login

-->
<div class="d-flex justify-content-center">
	<div class="row">
		<div class="col-md-6" style='background:yellow'>
			<form name="loginform" class='form-horizontal' id="loginform" action="<?php echo RUTA_LOGIN;?>" method="post">
				<div class='form-group'>
					<label for="nombreusuario" class='sr-only'>Nombre de usuario</label>
					<div class='col-12' style='margin-top:20px'>
						<input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title='Se necesita un nombre' placeholder="Nombre:" />
					</div>
				</div>
				<div class='form-group'>
					<label for="claveusuario" class='sr-only'>Contrase&ntilde;a</label>
					<div class='col-md-12'>
						<input type="password" class="form-control" name="claveusuario" id="claveusuario" title='Se necesita una clave' placeholder="Contrase&ntilde;a:"/>
					</div>
				</div>
				<input type="hidden" name="accion" id="accion" value="controlUsuarios"/>
				<div class='form-group'>
					<div class='col-md-12'>
						<input type="submit" class="form-control btn btn-primary btn-large" id='botonFormularioLogin' name='botonFormularioLogin' value="Acceder"/>
					</div>
				</div>
			</form>
		</div>
		<div class="col-12" style='margin-top:20px'>
			<a href="<?php echo RUTA_OLVIDO_CLAVE; ?>" title="Recupera tu contrase&ntilde;a perdida">¿Has perdido tu contrase&ntilde;a?</a>
		</div>
	</div>

</div>