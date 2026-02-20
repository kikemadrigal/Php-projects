<?php
require_once('app/config.php');
require_once('app/Conexion.php');
require_once('app/RepositorioFotos.php');
require_once('app/Foto.php');
$mensaje="";

$titulo ="Mapa usuario";
include_once("views/layouts/document-start.inc.php");
?>
	

<script type="text/javascript">
	var markers2=new Array();
	var map;
	var cargarfotos=function (){
			$.ajax({
				type: 'GET',
				url: 'https://www.fotomapa.es/views/map/mapgetalluserarray.php'
			}).done(function(info){
				//console.log(info);
				markers=JSON.parse(info);
				//console.log(markers.length+" fotos cargadas.");
				        //Create and open InfoWindow.
        		var infoWindow = new google.maps.InfoWindow();
		
				//console.log(markers.length);
				for (var i = 0; i < markers.length; i++) {
					var data = markers[i];
					console.log(data.user);
					var myLatlng = new google.maps.LatLng(data.lat, data.lng);
					var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
					var marker = new google.maps.Marker({
						position: myLatlng,
						label: data.name,
						map: map,
						title: data.text,
						animation: google.maps.Animation.DROP,
						icon: image
					});

					//Attach click event to the marker.
					(function (marker, data) {
						google.maps.event.addListener(marker, "click", function (e) {
							//Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
							infoWindow.setContent("<div style = 'width:100px;min-height:40px'><a href=https://www.fotomapa.es/photos/show/"+data.id+"><b>"+data.name.substring(0,data.name.length-4)+"</b><br><img src=../../resources/imagesusers/"+data.user+"/foto/"+data.name+" width=100px></img><br>"+data.text+"<br>" + data.type + "</a></div>");
							//infoWindow.setContent(content);
							infoWindow.open(map, marker);
						});
					})(marker, data);
				}
			});
	}	
	
	
	
	


    function initMap() {
		var murcia={lat: 37.995757, lng: -1.134553};
        var mapOptions = {
            //center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
			center: murcia,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
		//Creeamos el evento al pulsar capture las coordenadas
		google.maps.event.addListener(map, "click", function(evento) {
				//Puedo unirlas en una unica variable si asi lo prefiero
				lat = evento.latLng.lat();
				lng = evento.latLng.lng();
				document.getElementById("muestracoordenadas").innerHTML=lat+", "+lng;
				var opcion = confirm("¿Agregar nueva foto?\nLas fotos de usuarios no registrado tendrán que esperar la validaciónd el administrador");
				if (opcion == true) {
					document.location="https://www.fotomapa.es/photos/create/"+lat+","+lng;
				} 
		});
		 google.maps.event.addListener(map, "mousemove", function(evento) {
	         	/*lat = evento.latLng.lat();
				lng = evento.latLng.lng();
	         	document.getElementById("muestracoordenadas").innerHTML =lat+", "+lng;*/
	     });
    }
	 window.onload = function () {
        cargarfotos();
    }
	 
</script>

<div class="container">
	<div id="muestracoordenadas"></div>
	<div style="background-color: lightsalmon;padding: 20px"><div id="dvMap" style="width: 100%; height:400px; "></div>
</div>


<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFgSpcBibpRLAtMIX68M_DnUyrHQr2VnY&callback=initMap">
</script>
	
<div class="row">
	<div class="col-md-12">
		<?php if(!empty($mensaje)) echo "<br><div class='alert alert-danger' role='alert'>".$mensaje."</div>"; ?>
	</div>
</div>

	
	

<?php
include_once("views/layouts/document-end.inc.php");


?>