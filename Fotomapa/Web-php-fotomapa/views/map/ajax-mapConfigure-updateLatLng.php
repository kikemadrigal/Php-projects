<?php
	header("access-control-allow-origin: *");
	session_start();
	require_once( "../../app/config.php" );
	require_once( "../../app/RepositorioMapConfigure.php" );
	require_once( "../../app/ControlSesion.php" );
	require_once( "../../app/Conexion.php" );
	//require_once( "../../app/MapConfigure.php" );
	//require_once( "../../app/Usuario.php" );
	//require_once( "../../app/RepositorioUsuario.php" );
	
	$insertada=false;
	if ( ControlSesion::comprobar_sesion_iniciada() ) {
			$nombreUsuario = $_SESSION[ 'nombre' ];
	} else {
			$nombreUsuario = "IP:" . $_SERVER[ 'REMOTE_ADDR' ];
	}
		print("Desde mapConfigureUpdateLatLng se haobtenido los GET: ".$_GET['lat'].", ".$_GET['lng']);
	//if(isset($_GET)){
		Conexion::abrir_conexion();
		$conexion=Conexion::obtener_conexion();
		//1.Obtenemos el mapa de el usuario
		$mapConfigure=RepositorioMapConfigure::getMapaDeUnUsuario($conexion,$nombreUsuario);
		$mapConfigure->setLatposition($_GET['lat']);
		$mapConfigure->setLngPosition($_GET['lng']);
		//2.Actualizamos coordenadas de mapa
		$actualizada=RepositorioMapConfigure::updateLatLng($conexion,$mapaConfigure);
		//insertamos mensaje en datosmapa
		?>
		<script>
			document.getElementById("datosMapa").innerHTML="Actualiza!!: latitud: " +<?php echo $mapConfigure->getLatPosition()?>+", longitud "+<?php echo $mapConfigure->getLngPosition()?>;
		</script>
		<?php
		//print("las coordenadas a actualizar son: ".$mapConfigure->getLatPosition().", ".$mapConfigure->getLngPosition());
		Conexion::cerrar_conexion();
//	}
	
	
	echo $insertada;




?>