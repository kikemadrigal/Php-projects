<script type="text/javascript">
	var map;
	var markersArray = [];
	//var murcia;
	var pos;
	var mapConfigure;
	var lat;
	var lng;	



	var verSiExisteMapaUsuario=function(){
		$.ajax({
			type: 'GET',
			url: 'https://www.fotomapa.es/views/map/ajax-mapConfigure-isset.php'
		}).done(function(mapaExisteoNoExiste){
			//console.log(mapaExisteoNoExiste);
				if(mapaExisteoNoExiste==1){
					console.log('El mapa existe');
					//Si hay una entrada en mapConfigure con la ip o el usuario, obtenemos el mapa de usuario con todos los datos
					$.ajax({
						type: 'GET',
							url: 'https://www.fotomapa.es/views/map/ajax-mapConfigure-getMap.php'
						}).done(function(mapConfigureInfo){
							//Psamos el JSON a objeto javascript
							var arraysResultado=JSON.parse(mapConfigureInfo);
							document.getElementById("datosMapa").innerHTML="Coordenadas: "+arraysResultado["latPosition"]+", "+arraysResultado["lngPosition"]+", zoom: " + arraysResultado["zoom"]+", tipo: "+arraysResultado['type']+", marcadores: "+arraysResultado['maxMarkers']+", fecha: "+arraysResultado['timeStamp'];
							var latLng=new google.maps.LatLng(arraysResultado["latPosition"], arraysResultado["lngPosition"]);
							var zoom=parseInt(arraysResultado["zoom"]);
							var mapOptions = {
								center: latLng,
					            zoom: zoom,
					            mapTypeId: arraysResultado['type']
					        };
					        map.setOptions(mapOptions);					        
					});	
				}else if(mapaExisteoNoExiste==0){
					console.log('El mapa no existe');
					//selectConCiudades es una variable que almacena una cadena con un select
					document.getElementById("datosMapa").innerHTML=selectConPaises+selectConCiudades;
				}
		});
	}
    //El initmap se carga solo
	function initMap() {
    	if (pos==null){
    		//Ponemos el mapa en el centro de la tierra y muy alejado
    		pos={lat: 35.729513, lng: -11.678579};
    	}
        var mapOptions = {
			center: pos,
            zoom: 1,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
    }


    /*************************MAIN*******************/
    window.onload = function () {
		verSiExisteMapaUsuario();
		cargarEventos();
        cargarfotos(10000);
    }
    /***************FIN DE MAIN******************/ 
</script>


<div class="container">
	<div class="d-flex justify-content-between">
		<?php
		
		if(ControlSesion::comprobar_sesion_iniciada()){
			echo "<div>Pincha en el mapa para insertar un foto</div>";
		}else{
			echo "<div>Es necesario logearte o registrarte para insertar una foto.</div>";
		}
		?>
		<div id="muestracoordenadas"></div>
	</div>
	<div style="background-color: #F9F3F9;padding: 10px;">
	<!-- Este es el mapa-->
	<div id="dvMap" style="width: 100%; height:400px; "></div><br>

	<!--
	Aquí empiezan los botones que hay debajo del mapa
	 ________	  ________     ________     ________
	|________|   |________|   |________|   |________| 
	-->

	<?php
	//Si el usuario ha iniciado sesión
	if(ControlSesion::comprobar_sesion_iniciada()){
	?>

		<a class="btn btn-outline-secondary btn-sm " id="botonCentrarMapa" href="#" role="button" style="margin: 2px;" ><i class="fa fa-street-view"></i> Localízame</a>
		<a class="btn btn-outline-secondary btn-sm " id="botonPosicionActual" href="#" role="button" style="margin: 2px;"><i class="fa fa-camera"></i> Hacer foto en mi localización</a>
		<div class="dropdown" style="display: inline;">
		<a class="btn btn-outline-secondary btn-sm dropdown-toggle" href="#" id="menuConfiguracionDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-pressed="true" <?php echo $estado ?>>
				<i class="fa fa-map"></i> Configuración...
		</a>
		<div class="dropdown-menu " aria-labelledby="menuConfiguracionDropDown" aria-pressed="true" <?php echo $estado ?>>
			<a class="dropdown-item" href="#modalUpdateLocation" class="btn btn-primary" data-toggle="modal"><i class="fa fa-map-marker"></i> Localización inicial</a>
			<a class="dropdown-item" href="#modalUpdateZoom" class="btn btn-primary" data-toggle="modal" ><i class="fa fa-search-plus"></i> Zoom</a>
			<a class="dropdown-item" href="#modalUpdateTypeMap" class="btn btn-primary" data-toggle="modal"><i class="fa fa-map"></i> Tipo de mapa</a>	
			<a class="dropdown-item" href="#modalUpdateMaxMarkers" class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus"></i> Fotos máximas a ver.</a>	
			<a class="dropdown-item" href="#modalConfirmDeleteUserAndMap"  class="btn btn-primary" data-toggle="modal"><i class="fa fa-trash"></i> Borrar mis datos</a>	
		</div>
		</div>
			<div id="datosMapa" style="display: inline; font-size: 12px"></div>
		</div>
		<?php
	}else{
		?>
		<!--<span><a class='nav-link' href='<?php echo RUTA_LOGIN; ?>'><i class='fa fa-sign-in' aria-hidden='true'></i> Login</a></span>
		<a class='nav-link' style='display: inline;margin-left:20px' href='".RUTA_REGISTRO."'><i class='fa fa-registered' aria-hidden='true'></i> Registro</a>-->
		<a class="btn btn-outline-secondary btn-sm " id="botonCentrarMapa" >Localizame</a>
		<a class="btn btn-outline-secondary btn-sm " id="botonPosicionActual" style='display:none'></a>
	
	<?php
	}
	?>
	
	
</div>


<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFgSpcBibpRLAtMIX68M_DnUyrHQr2VnY&callback=initMap">
</script>
<script language="javascript" src="https://fotomapa.es/views/layouts/js/map.js"></script>

<?php require_once('views/map/modal-modalNewPhoto.php') ?>
<?php require_once('views/map/modal-confirmDeleteUserAndMap.php') ?>
<?php require_once('views/map/modal-updateLocation.php') ?>
<?php require_once('views/map/modal-updateZoom.php') ?>
<?php require_once('views/map/modal-updateMaxMarkers.php') ?>
<?php require_once('views/map/modal-updateTypeMap.php') ?>




