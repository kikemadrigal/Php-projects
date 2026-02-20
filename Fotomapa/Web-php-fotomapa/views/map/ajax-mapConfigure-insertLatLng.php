<?php
	header("access-control-allow-origin: *");
	//session_start();
	require_once( "../../app/config.php" );
	require_once( "../../app/RepositorioMapConfigure.php" );
	require_once( "../../app/ControlSesion.php" );
	require_once( "../../app/Conexion.php" );
	//require_once( "../../app/MapConfigure.php" );
	require_once( "../../app/Usuario.php" );
	require_once( "../../app/RepositorioUsuario.php" );
	$insertada=false;
	if ( ControlSesion::comprobar_sesion_iniciada() ) {
			$nombreUsuario = $_SESSION[ 'nombre' ];
		} else {
			$nombreUsuario = "IP:" . $_SERVER[ 'REMOTE_ADDR' ];
		}

	if(isset($_GET)){
		Conexion::abrir_conexion();
		$conexion=Conexion::obtener_conexion();
		$idUsuario=null;
		//Si es un usuario anónimo comprobamos que el usuario está creado
		$usuarioEstaCreado=RepositorioUsuario::comprobarSiExisteNombre( $conexion, $nombreUsuario );
		if($usuarioEstaCreado){
			//Si el usuario está ya creado obtenemos su id
			$idUsuario=RepositorioUsuario::obtener_id_usuario_por_nombre($conexion,$nombreUsuario);
			//Y registramos el mapa con este id
			$insertada=RepositorioMapConfigure::storedLatLng($conexion, $idUsuario,$_GET['lat'],$_GET['lng']);
		}else{
			//Si no está creado el usuario creamos uno
			$usuarioMapa=new Usuario("",$nombreUsuario,password_hash("UNO", PASSWORD_DEFAULT), "usuariosinregistrar","","","","",0,0);
			RepositorioUsuario::stored($conexion,$usuarioMapa);
			//insertamos las coordenadas del mapa
			$insertada=RepositorioMapConfigure::storedLatLng($conexion, $conexion->lastInsertId(),$_GET['lat'],$_GET['lng']);
		}
		
		
		Conexion::cerrar_conexion();
	}
	
	if($insertada){
		echo "Las coordenadas por defecto han cambiado a: lat: "+$_GET['lat']+", long: "+$_GET['lng'];
	}else{
		echo "Ha ocurrido un problema al cambiar las coordenadas.";
	}
	




?>