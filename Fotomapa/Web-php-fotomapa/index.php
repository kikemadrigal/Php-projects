<?php
session_start();//Obligatorio para trabajar con sesiones
$componentes_url=parse_url($_SERVER['REQUEST_URI']);
$ruta=$componentes_url['path'];
$partesRuta=explode("/", $ruta);
$partesRuta=array_filter($partesRuta);
$partesRuta=array_slice($partesRuta,0);
$rutaElegida='views/404.php';
//echo "<p>".$ruta."</p>";
//echo "REQUEST_URI--->".print_r($partesRuta);
/**
 * Archivos obligatorios
 */

require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ControlSesion.php" );
require_once( "app/ValidacionesFormularioLoginUsuario.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/RepositorioUserMessages.php");
require_once( "app/Usuario.php" );
require_once( "app/ObtenerUsuario.php" ); 

if($partesRuta[0]==''){ 
	$rutaElegida='views/photos/home.php';
}else if($partesRuta[0]=='home'){ 
	$rutaElegida='views/photos/home.php';
}else if($partesRuta[0]=='index.php'){ 
	$rutaElegida='views/photos/home.php';
}else if($partesRuta[0]=='user'){
	if(count($partesRuta)==1){
		$rutaElegida='views/user/login.php';
	}else if(count($partesRuta)==2){
		switch($partesRuta[1]){
			case 'login':
				$rutaElegida='views/user/login.php';
			break;
			case 'logout':
				$rutaElegida='views/user/logout.php';
			break;
			case 'create':
				$rutaElegida='views/user/create.php';
			break;
			case 'forgetpassword':
				$rutaElegida='views/user/forgetpassword.php';
			break;	
			case 'loginresetpassword':
				$rutaElegida='views/user/loginresetpassword.php';
			break;	
		}
	}else if(count($partesRuta)==3){
		switch($partesRuta[1]){
			case 'create-ok':
				$nombreUsuarioNuevoRegistrado=$partesRuta[2];
				$rutaElegida='views/user/create-ok.php';
				break;
			case 'loginresetpassword':
				$claveActivacion=$partesRuta[2];
				$rutaElegida='views/user/loginresetpassword.php';
				break;
		}

	}

}else if($partesRuta[0]=='photos'){
	if(count($partesRuta)==1){
		
	}else if(count($partesRuta)==2){
		switch($partesRuta[1]){
			case 'create':
				$lat=0;
				$lng=0;
				$rutaElegida='views/photos/create.php';
			break;
			case 'edit':
				$idFoto=$_POST['idFoto'];
				$rutaElegida='views/photos/edit.php';
			break;
			case 'delete':
				$idFoto=$_POST['idFoto'];
				$rutaElegida='views/photos/delete.php';
				break;
			case 'showall':
				$rutaElegida='views/photos/showall.php';
			break;
			case 'carrusel':
				$rutaElegida='views/photos/carrusel.php';
			break;
			case 'show-not-validate-anonymous':
				$rutaElegida='views/photos/shownotvalidateanonimous.php';
				break;
			case 'show-not-validate-register-users':
				$rutaElegida='views/photos/shownotvalidateregisterusers.php';
				break;
			case 'validate-photo':
				$idFoto=$_POST['idFoto'];
				$rutaElegida='views/photos/validate.php';
				break;

		}
	}else if(count($partesRuta)==3){
		switch($partesRuta[1]){
			case 'create':
				$coordenadas=explode(",", $partesRuta[2]);
				$lat=$coordenadas[0];
				$lng=$coordenadas[1];
				$rutaElegida='views/photos/create.php';
				break;
			case 'showall':
				$pagina=$partesRuta[2];
				$rutaElegida='views/photos/showall.php';
				break;
			case 'show':
				$idFoto=$partesRuta[2];
				$rutaElegida='views/photos/show.php';
				break;
			case 'fullscreenimage':
				$idFoto=$partesRuta[2];
				$rutaElegida='views/photos/fullscreenimage.php';
				break;
			
		}
		
	}



/**
 * API
 */


//http://fotomapa.es/api
}else if($partesRuta[0]=='api'){
	if($partesRuta[1]=='usuario'){
		if($partesRuta[2]=='showall'){
			$rutaElegida='api/user/showall.php';
		}else if($partesRuta[2]=='login'){
		
			$rutaElegida='api/user/login.php';
		}else if($partesRuta[2]=='create'){
		
			$rutaElegida='api/user/create.php';
		}
	}
	
	
	
	else if($partesRuta[1]=='photo'){
		require_once( "app/RepositorioFotos.php" );
		require_once("app/Foto.php");
		if($partesRuta[2]=='showcreator'){
			$rutaElegida='api/photos/showcreator.php';
		}else if($partesRuta[2]=='showall'){
			$rutaElegida='api/photos/showall.php';
		}else if($partesRuta[2]=='show'){
			//ECHO "HOLA DESDE SHOW-->".$partesRuta[3]; 
			$idFoto=$partesRuta[3];
			$rutaElegida='api/photos/show.php';
		}else if($partesRuta[2]=='create'){
			//ECHO "HOLA DESDE SHOW-->".$partesRuta[3]; 
			//$idFoto=$partesRuta[3];
			$rutaElegida='api/photos/create.php';
		}else{
			echo "<h3>Ruta photo mala: ".$partesRuta[0]."/".$partesRuta[1]."/".$partesRuta[2]."</h3>";
		}
	}
	
	
	
	
	else if($partesRuta[1]=='map'){
		echo 'map';
	}else if($partesRuta[1]=='location'){
		echo 'location';
	}















}else if($partesRuta[0]=='carrusel'){
	$rutaElegida='views/photos/carrusel.php';
}else if($partesRuta[0]=='map'){
	if(count($partesRuta)==1){
		$rutaElegida='views/map/map.php';
	}else if(count($partesRuta)==2){
		$mensaje=$_GET['mensaje'];
		$rutaElegida='views/map/map.php';
	}
}



else if($partesRuta[0]=='mapuser'){
	$rutaElegida='views/map/mapuser2.php';
}else if($partesRuta[0]=='search'){
	$rutaElegida='views/photo/showall.php';
}else if($partesRuta[0]=='photouser'){
	$rutaElegida='views/photo/showalluser.php';
}else if($partesRuta[0]=='download'){
	$rutaElegida='views/download/index.php';
}else if($partesRuta[0]=='contact'){
	$rutaElegida='views/contact/index.php';
}else if($partesRuta[0]=='chat'){
	$rutaElegida='views/chat/index.php';
}else if($partesRuta[0]=='print'){
	$rutaElegida='views/print/index.php';
}else if($partesRuta[0]=='info'){
	$rutaElegida='views/info/index.php';
}else if($partesRuta[0]=='analytics'){
	$rutaElegida='views/analytics/analytics.php';
}else if($partesRuta[0]=='404'){
	$rutaElegida='views/404.php';
}else if($partesRuta[0]=='gestor'){
	if(count($partesRuta)==1){
		$rutaElegida='views/gestor/index.php';
	}else if(count($partesRuta)==2){
		
		$gestorActual=$partesRuta[1];
		
		$rutaElegida='views/gestor/index.php';	
	}else if(count($partesRuta)==3){
		
		$gestorActual=$partesRuta[1];
		$pagina=$partesRuta[2];
		
		$rutaElegida='views/gestor/index.php';
	}
	
	
}else if($partesRuta[0]=='prueba'){
	$rutaElegida='views/map/map.php';
}else{
	$rutaElegida='views/404.php';
}


include_once $rutaElegida;
//echo "<br>Ruta elegida-->".$rutaElegida;

?>