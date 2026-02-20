/*
*Esta función llamará mediante ajax al servidor y le devolverá un array con 
*todas las fotos (markers, marcadores), límitadas por un máximo de fotos
*/
var cargarfotos=function (maxMarkers){
	console.log("marcadores maximos: "+maxMarkers);
	$.ajax({
		type: 'GET',
		url: 'https://www.fotomapa.es/views/map/mapgetallarray.php?maxMarkers='+maxMarkers
	}).done(function(info){
		//if(info.length>2){
			markers=JSON.parse(info);
    		var infoWindow = new google.maps.InfoWindow();
			for (var i = 0; i < markers.length; i++) {
				var data = markers[i];
				console.log(data.user);
				var myLatlng = new google.maps.LatLng(data.lat, data.lng);
				var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
				var marker = new google.maps.Marker({
					position: myLatlng,
					label: data.type,
					map: map,
					title: data.text,
					animation: google.maps.Animation.DROP,
					icon: image
				});
				markersArray.push(marker);
				(function (marker, data) {
					google.maps.event.addListener(marker, "click", function (e) {
						var rutaImagen="https://fotomapa.es/resources/imagesusers/"+data.user+"/"+data.name;
						infoWindow.setContent("<div style = 'width:100px;min-height:40px'><a href=https://www.fotomapa.es/photos/show/"+data.id+"><b>"+data.type.substring(0,26)+"</b><br><img src="+rutaImagen+" width=100px alt="+rutaImagen+"></img><br>"+data.text.substring(0,50)+"<br>" + data.timeStamp + "</a></div>");
						infoWindow.open(map, marker);
					});
				})(marker, data);
			}
		//}
	});
}
var cargarFotosDeUnUsuario=function(){
	//document.write('<h1>Estas en cargar fotos de usuario</h1>');
	$.ajax({
		type: 'GET',
		url: 'https://www.fotomapa.es/views/map/mapgetalluserarray.php'
	}).done(function(info){
		
			let marcadores=JSON.parse(info);
			console.log(marcadores);
    		var infoWindow = new google.maps.InfoWindow();
			for (var i = 0; i < marcadores.length; i++) {
				var data = marcadores[i];
				console.log(data.user);
				var myLatlng = new google.maps.LatLng(data.lat, data.lng);
				var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
				var marker = new google.maps.Marker({
					position: myLatlng,
					label: data.type,
					map: map,
					title: data.text,
					animation: google.maps.Animation.DROP,
					icon: image
				});
				markersArray.push(marker);
				(function (marker, data) {
					google.maps.event.addListener(marker, "click", function (e) {
						var rutaImagen="https://fotomapa.es/resources/imagesusers/"+data.user+"/"+data.name;
						infoWindow.setContent("<div style = 'width:100px;min-height:40px'><a href=https://www.fotomapa.es/photos/show/"+data.id+"><b>"+data.type.substring(0,26)+"</b><br><img src="+rutaImagen+" width=100px alt="+rutaImagen+"></img><br>"+data.text.substring(0,50)+"<br>" + data.timeStamp + "</a></div>");
						infoWindow.open(map, marker);
					});
				})(marker, data);
			}
	
	});
}
var borrarFotos=function (){
	for (var i = 0; i < markersArray.length; i++ ) {
    	markersArray[i].setMap(null);
  	}
    markersArray.length = 0;
}	

//Esta función mostrará la localización actual
var mostrarPosicionActual=function(){
	console.log("has hecho click en localízame");
	var infoWindow = new google.maps.InfoWindow({map: map});
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        infoWindow.setPosition(pos);
        infoWindow.setContent('Esta es tu localización.');
        map.setCenter(pos);
        map.setZoom(14);
      }, function() {
        infoWindow.setPosition(murcia);
    	infoWindow.setContent(true ?'Error: El servicio de localización a fallado.' :'Error: Tu navegador no soporta geolocalización.');
      });
    } else {
     	infoWindow.setPosition(murcia);
    	infoWindow.setContent(false ?'Error: El servicio de localización a fallado.' :'Error: Tu navegador no soporta geolocalización.');
    }
}

var selectConPaises="&nbsp;&nbsp;<spam id='aunNoHasElegidoTuLocalizacion' style='display: inline;'>Aún no has elegido tu localización inicial:   </spam><select id='selectConPaises' style='display: inline;' >"+
					"<option value='Alava'>España</option></select>";
var selectConCiudades="&nbsp;&nbsp;<select id='selectConCiudades' style='display: inline;' onchange='selectHaCambiadoDeCiudad(this.value)'>"+
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
					"<option value='Ciudad-Real'>Ciudad Real</option>"+
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
					"</select>";
/*
*Han cambiado las fotos máximas hace una llamada através de ajax para que actualice con php 
*el campo maxMarkers de la tabla fotos
*/

var theMaximumPhotosHaveChanged=function(maxMarkers){
	document.getElementById("datosMapa").innerHTML="Marcadores máximos actualizados a: " +maxMarkers;
	$.ajax({
		type: 'GET',
		url: 'https://www.fotomapa.es/views/map/ajax-mapConfigure-updateMaxMarkers.php?maxMarkers='+maxMarkers
	}).done(function(info){
		console.log('Los marcadores máximos han cambiado a ha cambiado: '+info);
	});

	document.getElementById('maxMarkersValue').innerHTML=maxMarkers;
	borrarFotos();
	cargarfotos(maxMarkers);
}
	 

var selectHaCambiadoElTipoDeMapa=function(typeMap){
	//Creamos el mapa del usuario
	console.log('estas dentro de se ha cambiado el tipo de mapa'+typeMap);
	$.ajax({
		type: 'GET',
		url: 'https://www.fotomapa.es/views/map/ajax-mapConfigure-updateTypeMap.php?typeMap='+typeMap
	}).done(function(info){
		document.getElementById("datosMapa").innerHTML="Tipo de mapa cambiado: "+typeMap;
		switch(typeMap) {
		    case 'roadmap':
		        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
		        break;
		    case 'satellite':
		         map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
		        break;
		    case 'hybrid':
		         map.setMapTypeId(google.maps.MapTypeId.HYBRID);
		        break;
		    case 'terrain':
		         map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
		        break;
		    default:
		         map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
		}
	});
}











/**
 * 
 * 
 * 
 * 
 *Eventos
 * 
 * 
 * 
 */









var cargarEventos=function(){
	google.maps.event.addListener(map, "click", function(evento) {
		//console.log('Has hecho click en crear nueva foto');	
		//Puedo unirlas en una unica variable si asi lo prefiero
		lat = evento.latLng.lat();
		lng = evento.latLng.lng();
		document.getElementById("muestracoordenadas").innerHTML=lat+", "+lng;
		$.ajax({
			type: 'GET',
			url: 'https://www.fotomapa.es/views/user/ajax_check_registered_user.php'
		}).done(function(respuesta){
			//console.log('La respuesta ha si esta registrao o no es: '+respuesta);
			if(respuesta){
				//console.log('El usuario está registrado');
				$('#modalNewPhotos').modal('toggle');
			}else{
				//console.log('El usuario no está registrado');
				alert('Es necesario estar logeado o registrado para inserta fotos');
			}
		});
	
		//var opcion = confirm("¿Agregar nueva foto?\nLas fotos de usuarios no registrado tendrán que esperar la validaciónd el administrador");
		//if (opcion == true) {
			//document.location="http://www.fotomapa.es/photos/create/"+lat+","+lng;
		//} 
	});
	//Cargamos el evento al mover sobre el mapa
	google.maps.event.addListener(map, "mousemove", function(evento) {
     	lat = evento.latLng.lat();
		lng = evento.latLng.lng();
		if(lat!=null && lng!=null){
			document.getElementById("muestracoordenadas").innerHTML =lat+", "+lng;	
		}
	});
	//Acción sacar foto de mi posición actual
    var botonPosicionActual=document.getElementById('botonPosicionActual');
    	botonPosicionActual.addEventListener("click", function(){
	    	if (navigator.geolocation) {
		          navigator.geolocation.getCurrentPosition(function(position) {
		          var lat= position.coords.latitude;
		          var lng= position.coords.longitude;
		          document.location="http://www.fotomapa.es/photos/create/"+lat+","+lng;
	          });
		    }else {
		       alert('Error, no se obtuvo la posición actual');
		    }
	});
	//Acción centrar Mapa
	var centrarMapa=document.getElementById('botonCentrarMapa');
    	centrarMapa.addEventListener("click", function(){
    		mostrarPosicionActual();
	});
    /**Acción del deslizador que está dentro de  views/map/modal-updateMaxMarkers.php
  	* que a su vez también es incluido dentro de map.inc.php.
  	*/
    var deslizadorParaCambiarFotosMaximas=document.getElementById('deslizadorParaCambiarFotosMaximas');
    deslizadorParaCambiarFotosMaximas.addEventListener("change", function(){
    	//console.log('el valor es '+this.value);
    	theMaximumPhotosHaveChanged(this.value);
	});	
  	/**
  	*Acciones para los radiobuttoon que están en views/map/modal-updateTypeMaps.php
  	* que a su vez tambien está incluido dentro de map.inc.php)
  	*/
    //Fijate que el nombre es getElements... se le pone una s porque devuelve un array
    var typeMapRadio=document.getElementsByName('typeMapRadio');
	for(var i =0; i<typeMapRadio.length; i++) {
		typeMapRadio[i].addEventListener("click", function(){
	    	console.log('Has hecho click en el radio con valor: '+this.value);
	    	selectHaCambiadoElTipoDeMapa(this.value);
		});	
	}
}


//This function will be called cuando selecciones una ciudad del select incluido en map.inc.php o del select que está en modal-updatelatlong
var selectHaCambiadoDeCiudad=function(location){
	//console.log('has pincha en el select, valor '+location);
	//1.Obtenemos las coordenadas
	$.ajax({
		type: 'GET',
		url: 'https://www.fotomapa.es/views/map/ajax-mapConfigure-getLocation.php?location='+location
	}).done(function(info){
		var location=JSON.parse(info);
		//Cuando obtengamos las coordenadas las actualizamos
		if(location.length>0){
			document.getElementById("datosMapa").innerHTML=" Datos cambiados: latitud: " +location[0]+", longitud "+location[1];
			//Creamos el mapa del usuario
			$.ajax({
				type: 'GET',
				url: 'https://www.fotomapa.es/views/map/ajax-mapConfigure-insertLatLng.php?lat='+location[0]+"&lng="+location[1]
			}).done(function(info){
				pos = {
		          lat: location[0],
		          lng: location[1]
		        };
		        //console.log(info);
		       map.setZoom(14);
		       map.setCenter(pos);
		       document.getElementById("selectConCiudades").style.display='none';
		       document.getElementById("aunNoHasElegidoTuLocalizacion").style.display='none';
		       document.getElementById("selectConPaises").style.display='none';
				//document.getElementById("datosMapa").innerHTML="Datos cambiados: latitud: " +location[0]+", longitud "+location[1]+", mapa actualizado";
			});
			
		}

	});
}
