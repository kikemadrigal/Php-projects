<?php
	header("access-control-allow-origin: *");

	$localizacion=$_GET['location'];
	$latLng=array();
	//0 es lat, 1 es long
	if($localizacion=='Alava'){
		$latLng[0]=40.4167754;
		$latLng[1]=-3.7037901999999576;
	}else if($localizacion=='Albacete'){
		$latLng[0]=38.994349;
		$latLng[1]=-1.858542400000033;
	}else if($localizacion=='Alicante'){
		$latLng[0]=38.3459963;
		$latLng[1]=-0.4906855000000405;
	}else if($localizacion=='Almeria'){
		$latLng[0]=36.834047;
		$latLng[1]=-2.4637136000000055;
	}else if($localizacion=='Asturias'){
		$latLng[0]=43.3613953;
		$latLng[1]=-5.8593266999999973;
	}else if($localizacion=='Avila'){
		$latLng[0]=40.656685;
		$latLng[1]=-4.681208599999991;
	}else if($localizacion=='Badajoz'){
		$latLng[0]=38.8794495;
		$latLng[1]=-6.970653500000026;
	}else if($localizacion=='Barcelona'){
		$latLng[0]=41.3850639;
		$latLng[1]=2.1734034999999494;
	}else if($localizacion=='Burgos'){
		$latLng[0]=42.3439925;
		$latLng[1]=-3.6969060000000127;
	}else if($localizacion=='Caceres'){
		$latLng[0]=39.4752765;
		$latLng[1]=-6.3724247000000105;
	}else if($localizacion=='Cadiz'){
		$latLng[0]=36.5270612;
		$latLng[1]=-6.288596200000029;
	}else if($localizacion=='Cantabria'){
		$latLng[0]=43.1828396;
		$latLng[1]=-3.9878426999999874;
	}else if($localizacion=='Castellon'){
		$latLng[0]=39.9863563;
		$latLng[1]=-0.051324600000043574;
	}else if($localizacion=='Ciudad-Real'){
		$latLng[0]=38.9848295;
		$latLng[1]=-3.927377799999931;
	}else if($localizacion=='Cordoba'){
		$latLng[0]=37.8881751;
		$latLng[1]=-4.7793834999999945;
	}else if($localizacion=='Cuenca'){
		$latLng[0]=40.0703925;
		$latLng[1]=-2.1374161999999615;
	}else if($localizacion=='Gerona'){
		$latLng[0]=41.9794005;
		$latLng[1]=2.821426400000064;
	}else if($localizacion=='Granada'){
		$latLng[0]=37.1773363;
		$latLng[1]=-3.5985570999999936;
	}else if($localizacion=='Guadalajara'){
		$latLng[0]=40.632489;
		$latLng[1]=-3.1601699999999937;
	}else if($localizacion=='Guipuzcoa'){
		$latLng[0]=43.0756299;
		$latLng[1]=-2.223666699999967;
	}else if($localizacion=='Islas-Baleares'){
		$latLng[0]=39.3587759;
		$latLng[1]=2.735632799999962;
	}else if($localizacion=='Jaen'){
		$latLng[0]=37.7795941;
		$latLng[1]=-3.7849056999999675;
	}else if($localizacion=='La-Corunia'){
		$latLng[0]=43.3623436;
		$latLng[1]=-8.411540100000025;
	}else if($localizacion=='La-Rioja'){
		$latLng[0]=42.2870733;
		$latLng[1]=-2.5396029999999428;
	}else if($localizacion=='Las-Palmas'){
		$latLng[0]=28.1235459;
		$latLng[1]=-15.436257399999931;
	}else if($localizacion=='Leon'){
		$latLng[0]=42.5987263;
		$latLng[1]=-5.567095900000027;
	}else if($localizacion=='Lugo'){
		$latLng[0]=43.0097384;
		$latLng[1]=-7.55675819999999;
	}else if($localizacion=='Madrid'){
		$latLng[0]=40.4167754;
		$latLng[1]=-3.7037901999999576;
	}else if($localizacion=='Malaga'){
		$latLng[0]=36.7212737;
		$latLng[1]=-4.42139880000002;
	}else if($localizacion=='Murcia'){
		$latLng[0]=37.9922399;
		$latLng[1]=-1.1306544000000258;
	}else if($localizacion=='Navarra'){
		$latLng[0]=42.6953909;
		$latLng[1]=-1.6760690999999497;
	}else if($localizacion=='Orense'){
		$latLng[0]=42.33578929999999;
		$latLng[1]=-7.863880999999992;
	}else if($localizacion=='Palencia'){
		$latLng[0]=42.0096857;
		$latLng[1]=-4.528801599999952;
	}else if($localizacion=='Pontevedra'){
		$latLng[0]=42.4298846;
		$latLng[1]=-8.644620199999963;
	}else if($localizacion=='Salamanca'){
		$latLng[0]=40.9701039;
		$latLng[1]=-5.663539700000001;
	}else if($localizacion=='Segovia'){
		$latLng[0]=40.9429032;
		$latLng[1]=-4.1088068999999905;
	}else if($localizacion=='Sevilla'){
		$latLng[0]=37.3890924;
		$latLng[1]=-5.984458899999936;
	}else if($localizacion=='Soria'){
		$latLng[0]=41.7665972;
		$latLng[1]=-2.4790305999999873;
	}else if($localizacion=='Tarragona'){
		$latLng[0]=41.1188827;
		$latLng[1]=1.2444908999999598;
	}else if($localizacion=='Tenerife'){
		$latLng[0]=28.2915637;
		$latLng[1]=-16.629130400000008;
	}else if($localizacion=='Teruel'){
		$latLng[0]=40.3456879;
		$latLng[1]=-1.1064344999999776;
	}else if($localizacion=='Toledo'){
		$latLng[0]=39.8628316;
		$latLng[1]=-4.02732309999999;
	}else if($localizacion=='Valencia'){
		$latLng[0]=39.4699075;
		$latLng[1]=-0.3762881000000107;
	}else if($localizacion=='Valladolid'){
		$latLng[0]=41.652251;
		$latLng[1]=-4.724532100000033;
	}else if($localizacion=='Vizcaya'){
		$latLng[0]=43.2204286;
		$latLng[1]=-2.69838679999998;
	}else if($localizacion=='Zamora'){
		$latLng[0]=41.5034712;
		$latLng[1]=-5.746787899999958;
	}else if($localizacion=='Zaragoza'){
		$latLng[0]=41.6488226;
		$latLng[1]=-0.8890853000000334;
	}
		
	echo json_encode($latLng);			
					/*
					
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
		
					"<option value='Malaga'>Málaga </option>"+
				
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


					*/

	




?>