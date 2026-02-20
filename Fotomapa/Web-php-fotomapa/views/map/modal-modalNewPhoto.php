<script>
	var seHaConfirmadoCrearNuevaFoto=function(){
    console.log('se ha confirmado crear nueva foto');
		document.location="http://www.fotomapa.es/photos/create/"+lat+","+lng;
	}

</script>
<!-- Modal -->
<div class="modal fade" id="modalNewPhotos" tabindex="-1" role="dialog" aria-labelledby="Confirmar-nueva-foto" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear foto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>¿Desea crear en estas coordenadas una foto?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" id='botonConfirmarCrearNuevaFoto' class="btn btn-primary" onclick="seHaConfirmadoCrearNuevaFoto()" data-dismiss="modal">Si</button>
      </div>
    </div>
  </div>
</div>