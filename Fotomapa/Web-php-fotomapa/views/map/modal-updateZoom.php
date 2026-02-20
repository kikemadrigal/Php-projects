<?php
	//require_once( "app/config.php" );
	require_once( "app/RepositorioMapConfigure.php" );
	require_once( "app/ControlSesion.php" );
	require_once( "app/Conexion.php" );
	Conexion::abrir_conexion();
	$conexion=Conexion::obtener_conexion();
	$zoom=RepositorioMapConfigure::getZoom($conexion);
	Conexion::cerrar_conexion();
?>
<script>
	var haCambiadoElZoom=function(zoom){
		document.getElementById("datosMapa").innerHTML="Nuevo zoom: " +zoom;
		$.ajax({
			type: 'GET',
			url: 'https://www.fotomapa.es/views/map/ajax-mapConfigure-updateZoom.php?zoom='+zoom
		}).done(function(info){
			console.log('El zoom ha cambiado: '+info);
		});
		map.setZoom(parseInt(zoom));
		document.getElementById('valorZoom').innerHTML=zoom;
	}

</script>

<!-- Modal -->
<div class="modal fade" id="modalUpdateZoom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar zoom</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       	<spam>Mueve el deslizador:</spam>      		
		<input type="range" min="0" max="20" step="1" value="<?php echo $zoom; ?>"  onchange="haCambiadoElZoom(this.value)"> <spam id='valorZoom' style="display: inline;"><?php echo $zoom; ?></spam>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

