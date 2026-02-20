<br><br><br>
	<h4 class="d-flex justify-content-center">Actualizar comando</h4>
	
	<div class="row d-flex justify-content-center">
		<div class="col-md-6">
			<br><br>
			
            <form method="post"  action="<?php echo base_url()."comandos/update"; ?>" >
                <div class="form-group">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $comando->nombre; ?>" />
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="datos" name="datos"><?php echo $comando->datos;?></textarea>
                </div>
                <input type="hidden" id="id" name="id" value="<?php echo $comando->id; ?>">
                <div class="form-group d-flex justify-content-center">
                    <input type='submit' name='submit' value='Actualizar' class='btn btn-success m-5' />
                    <a href="<?= base_url()."comandos/index";?>" type="button" class="btn btn-primary m-5">Volver</a>
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
        <a href='<?php echo base_url()."comandos/delete/".$comando->id; ?>'  class="btn btn-primary">Si</a>
	  </div>
    </div>
  </div>
</div>