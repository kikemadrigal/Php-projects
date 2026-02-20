<script>
	/*var selectHaCambiadoDeTipoDeMapa=function(typeMap){
		map.setMapTypeId(typeMap);
	}*/
</script>
<!-- Modal -->
<div class="modal fade" id="modalUpdateTypeMap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar tipo de mapa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Tipo de mapa:</spam>
       <!-- <select id='selectModalTypeMap' onchange='selectHaCambiadoDeTipoDeMapa(this.value)'>"+
  			"<option value='terrain'>Terrain</option> "+
  			"<option value='satellite'>satellite</option>"+
  			"<option value='hybrid'>hybrid</option>"+
  			"<option value='roadmap'>roadmap</option>"+
  			"</select>
    		<div>Los siguientes tipos de mapas están disponibles en la Maps JavaScript API:<br/>
    			<p>roadmap: muestra la vista del mapa de carreteras predeterminado. Este es el modo de mapa predeterminado.</p>
    			<p>satellite muestra imágenes satelitales de Google Earth.</p>
    			<p>hybrid muestra una combinación de vistas normales y satelitales.</p>
    			<p>terrain muestra un mapa físico basado en información de terreno.</p>
    		</div>-->
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="typeMapRadio"  value="roadmap">
            <b>Roadmap:</b> muestra la vista del mapa de carreteras predeterminado. Este es el modo de mapa predeterminado.
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="typeMapRadio"  value="satellite">
            <b>Satellite:</b> muestra imágenes satelitales de Google Earth.
          </label>
        </div>
        <div class="form-check disabled">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="typeMapRadio"  value="hybrid" >
           <b>Hybrid:</b> muestra una combinación de vistas normales y satelitales.
          </label>
        </div>
        <div class="form-check disabled">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="typeMapRadio"  value="terrain" >
            <b>Terrain:</b> muestra un mapa físico basado en información de terreno.
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

