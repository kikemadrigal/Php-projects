<?php
	//El form helper nos ayuda a crear los formularios (campos, botones, hidden) de una manera más segura y que no tenga ningún inconveniente con las codificaciones
	//El siguiente ejemplo es lo mismo que los de abajo pero con el helper de codeigniter
	//form_open es para generar un formulario, el  1 parámetro que recibe es la acción, el segundo los parámtros en formato de arry
	
	/*
	echo form_opem(base_url()."clientes/insert",array('method'=>'post', 'id'=>'formularioInsertarCliente'));
	echo form_label('cif');
	echo form_input(array('type'=>'text', 'name'=>'cif','required'=>true, 'class'=>'form-control'));
	echo form_close;
	*/
?>


<br>
<br>
<br>
<h4 class="d-flex justify-content-center">Crear cliente</h4>
<div class="row d-flex justify-content-center">
	<div class="col-md-6">
		<form method="post" action="<?=base_url()."clientes/insert";?>" >
			<div class="form-group">
				<input type="text" class="form-control" id="cif" name="cif" placeholder="cif" pattern="{2,64}" required>
			</div>
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
	