
<br>
<br>
<br>
<h4 class="d-flex justify-content-center">Crear comando</h4>
<div class="row d-flex justify-content-center">
	<div class="col-md-6">
		<form method="post" action="<?=base_url()."comandos/insert";?>" >
			<div class="form-group">
				<input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="datos" name="datos" placeholder="datos">
			</div>
			<div class="form-group d-flex justify-content-center">	
				<a href="<?=base_url()?>" type="button" class="btn btn-primary m-5">Volver</a>
				<input type="submit" name="submit" class="btn btn-primary btn btn-success m-5" value="Añadir" />
			</div>
			
			</button>
		</form>
	</div>
</div>
	