<script>
	/*var selectHaCambiadoModal=function(){
		var location=document.getElementById("selectModal").value;
		console.log('has pincha en el selectModal, valor '+location);
		$.ajax({
			type: 'GET',
			url: 'https://www.fotomapa.es/views/map/ajax-mapConfigure-getLocation.php?location='+location
		}).done(function(info){
			console.log('getLocation ha obtenido las coordenadas: '+info);
			var location=JSON.parse(info);
			console.log('coordenadas: '+location[0]+","+location[1]);
			if(location.length>0){
				document.getElementById("datosMapa").innerHTML="latitud: " +location[0]+", longitud "+location[1];

			}
		});
	}*/

</script>
<!-- Modal -->
<div class="modal fade" id="modalUpdateLocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar localización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        localización inicial:</spam>
        <select id='selectModal' onchange='selectHaCambiadoDeCiudad(this.value)'>"+
			"<option value='Alava'>Álava</option> "+
			"<option value='Albacete'>Albacete</option>"+
			"<option value='Alicante'>Alicante</option>"+
			"<option value='Almeria'>Almería</option>"+
			"<option value='Asturias'>Asturias</option>"+
			"<option value='Avila'>Ávila </option>"+
			"<option value='Badajoz'>Badajoz </option>"+
			"<option value='Barcelona'>Barcelona </option>"+
			"<option value='Burgos'>Burgos </option>"+
			"<option value='Caceres'>Cáceres </option>"+
			"<option value='Cadiz'>Cádiz </option>"+
			"<option value='Cantabria'>Cantabria </option>"+
			"<option value='Castellon'>Castellón </option>"+
			"<option value='Ciudad Real'>Ciudad Real</option>"+
			"<option value='Cordoba'>Córdoba </option>"+
			"<option value='Cuenca'>Cuenca </option>"+
			"<option value='Gerona'>Gerona </option>"+
			"<option value='Granada'>Granada </option>"+
			"<option value='Guadalajara'>Guadalajara </option>"+
			"<option value='Guipuzcoa'>Guipúzcoa </option>"+
			"<option value='Huelva'>Huelva </option>"+
			"<option value='Huesca'>Huesca </option>"+
			"<option value='Islas-Baleares'>Islas Baleares</option>"+
			"<option value='Jaen'>Jaén </option>"+
			"<option value='La-Corunia'>La Coruña</option>"+
			"<option value='La-Rioja'>La Rioja</option>"+
			"<option value='Las-Palmas'>Las Palmas</option>"+
			"<option value='Leon'>León </option>"+
			"<option value='Lerida'>Lérida </option>"+
			"<option value='Lugo'>Lugo </option>"+
			"<option value='Madrid'>Madrid </option>"+
			"<option value='Malaga'>Málaga </option>"+
			"<option value='Murcia'>Murcia </option>"+
			"<option value='Navarra'>Navarra</option>"+
			"<option value='Orense'>Orense </option>"+
			"<option value='Palencia'>Palencia </option>"+
			"<option value='Pontevedra'>Pontevedra  </option>"+
			"<option value='Salamanca'>Salamanca</option>"+
			"<option value='Segovia'>Segovia</option>"+
			"<option value='Sevilla'>Sevilla </option>"+
			"<option value='Soria'>Soria </option>"+
			"<option value='Tarragona'>Tarragona </option>"+
			"<option value='Tenerife'>Tenerife </option>"+
			"<option value='Teruel'>Teruel </option>"+
			"<option value='Toledo'>Toledo </option>"+
			"<option value='Valencia'>Valencia </option>"+
			"<option value='Valladolid'>Valladolid </option>"+
			"<option value='Vizcaya'>Vizcaya </option>"+
			"<option value='Zamora'>Zamora </option>"+
			"<option value='Zaragoza'>Zaragoza </option>"+
			"</select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

