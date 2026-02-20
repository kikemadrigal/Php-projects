<script>
	var seHaConfirmado=function(){
		console.log('has borrado los datos');
		$.ajax({
			type: 'GET',
			url: 'https://www.fotomapa.es/views/map/ajax-deleteUserAndMap.php'
		}).done(function(info){
      location.href ="https://fotomapa.es"; 
        /*if(info==1){
          document.getElementById("datosMapa").innerHTML="Exito al borrar";
          location.href ="https://fotomapa.es"; 
        }else{
          document.getElementById("datosMapa").innerHTML=info;
        }
      }*/
		});
	}

</script>
<!-- Modal -->
<div class="modal fade" id="modalConfirmDeleteUserAndMap" tabindex="-1" role="dialog" aria-labelledby="Conformar-borrado" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Borrar datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>¿Está seguro que desea borrar sus datos?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" onclick="seHaConfirmado()" data-dismiss="modal">Si</button>
      </div>
    </div>
  </div>
</div>

