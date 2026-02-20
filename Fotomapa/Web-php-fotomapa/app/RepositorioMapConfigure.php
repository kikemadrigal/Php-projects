<?php
class RepositorioMapConfigure {

	function __construct() {}

	/**************************SELECT*******************************************/
	//Select m.id, m.latPosition, m.lngPosition,m.zoom,m.type,m.minMarkers,m.maxMarkers,m.timeStamp from mapConfigure m LEFT OUTER JOIN usuarios u ON m.idUser=u.id WHERE m.idUser=81
	
	//Obtener un array de objetos foto con todas las fotos
	/*public static function getConfigureMap( $conexion ) {
		$mapa = array();
		if ( isset( $conexion ) ) {
			try {
				require_once( "Foto.php" );
				$sql = "SELECT * FROM fotos ORDER BY timestamp DESC";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						//$id, $name, $text, $type, $address, $city, $country, $lat, $lng, $user,$validada, $timestamp
						$foto = new Foto( $linea[ 'id' ], $linea[ 'name' ], $linea[ 'name' ], $linea[ 'text' ], $linea[ 'type' ], $linea[ 'address' ], $linea[ 'city' ], $linea[ 'country' ], $linea[ 'lat' ], $linea[ 'lng' ], $linea[ 'user' ], $linea[ 'validada' ], $linea[ 'timestamp' ] );
						$fotos[] = $foto;
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fotos;
	}*/
	
	public static function getMapaDeUnUsuario( $conexion,$nombreUsuario ) {
		$mapConfigure = null;
		if ( isset( $conexion ) ) {
			try {
				require_once( "MapConfigure.php" );
				//$sql = "SELECT * FROM mapConfigure WHERE id=:id";
				$sql="Select u.nombre,m.id,m.locationAllow, m.latPosition, m.lngPosition,m.zoom,m.type,m.minMarkers,m.maxMarkers,m.timeStamp,m.idUser from mapConfigure m LEFT OUTER JOIN usuarios u ON m.idUser=u.id WHERE u.nombre=:nombreUsuario";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':nombreUsuario', $nombreUsuario, PDO::PARAM_STR );
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						//$id, $name, $text, $type, $address, $city, $country, $lat, $lng, $user,$validada, $timestamp
						$mapConfigure = new MapConfigure( $linea[ 'id' ],$linea[ 'locationAllow' ], $linea[ 'latPosition' ], $linea[ 'lngPosition' ], $linea[ 'zoom' ], $linea[ 'type' ], $linea[ 'minMarkers' ], $linea[ 'maxMarkers' ], $linea[ 'timeStamp' ],$linea['idUser'] );
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $mapConfigure;
	}
	public static function getIdMapaDeUnUsuario( $conexion,$nombreUsuario ) {
		$idMapa = null;
		if ( isset( $conexion ) ) {
			try {
				require_once( "MapConfigure.php" );
				$sql="Select m.id from mapConfigure m LEFT OUTER JOIN usuarios u ON m.idUser=u.id WHERE u.nombre=:nombreUsuario";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':nombreUsuario', $nombreUsuario, PDO::PARAM_STR );
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						$idMapa = $linea[ 'id' ];
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $idMapa;
	}
	public static function getLoalizacionPermitidaMapaDeUnUsuario($conexion, $idMap){
		$localizacionPermitida = false;
		if ( isset( $conexion ) ) {
			try {
				require_once( "MapConfigure.php" );
				$sql="Select locationAllow from mapConfigure WHERE id=:id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $idMap, PDO::PARAM_INT );
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						 $localizacionPermitida=$linea[ 'locationAllow' ];
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $localizacionPermitida;
	}
	public static function getZoom($conexion){
		$zoom=null;
		//1.Obtenemos el idmap del usuario
		require_once('ControlSesion.php');
		$idMap=RepositorioMapConfigure::getIdMapaDeUnUsuario($conexion,ControlSesion::getNameUsuario());
		if ( isset( $conexion ) ) {
			try {
				$sql="Select zoom from mapConfigure WHERE id=:id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $idMap, PDO::PARAM_INT );
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						 $zoom=$linea[ 'zoom' ];
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $zoom;
	}
	public static function getMaxMarkers($conexion){
		$maxMarkers=null;
		//1.Obtenemos el idmap del usuario
		require_once('ControlSesion.php');
		$idMap=RepositorioMapConfigure::getIdMapaDeUnUsuario($conexion,ControlSesion::getNameUsuario());
		if ( isset( $conexion ) ) {
			try {
				$sql="Select maxMarkers from mapConfigure WHERE id=:id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $idMap, PDO::PARAM_INT );
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						 $maxMarkers=$linea[ 'maxMarkers' ];
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $maxMarkers;
	}
	
	/***********************************FIN DE SELECT***************************/
	
	
	/***********************INSERT********************************************/
	public static function stored($conexion, $mapConfigure, $lat, $lng){
		$insertada = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "INSERT INTO mapConfigure (locationAllow, latPosition, lngPosition, zoom, type, minMarkers, maxMarkers, timeStamp, idUser)  VALUES (:locationAllow, :latPosition, :lngPosition, :zoom, :typw, :minMarkers, :maxMarkers, :timeStamp, idUser) ";
				$sentencia = $conexion->prepare( $sql );
				//Tenemos que indica el valor de los parámetros con el métdo bind ara enlazar parámetro
				//1.Le indicamos que parametro que queremos enlazar, 2 que valor va a tener el parámetro, 3 tenemos que indicar de que tipo es este parámetro
				$sentencia->bindParam( ':locationAllow', $mapConfigure->getLocationAllow(), PDO::PARAM_INT);
				$sentencia->bindParam( ':latPosition', $mapConfigure->getLatPosition(), PDO::PARAM_STR );
				$sentencia->bindParam( ':lngPosition', $mapConfigure->getLngPosition(), PDO::PARAM_STR );
				$sentencia->bindParam( ':zoom', $mapConfigure->getZoom(), PDO::PARAM_INT );
				$sentencia->bindParam( ':type', $mapConfigure->getType(), PDO::PARAM_INT );
				$sentencia->bindParam( ':minMarkers', $mapConfigure->getMinMarkers(), PDO::PARAM_INT );
				$sentencia->bindParam( ':maxMarkers', $mapConfigure->getMaxMarkers(), PDO::PARAM_INT );
				$sentencia->bindParam( ':timestamp', $mapConfigure->getTimeStamp(), PDO::PARAM_STR);
				$sentencia->bindParam( ':idUser', $mapConfigure->getIdUser(), PDO::PARAM_INT );
				$insertada = $sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $insertada;		
	}
	//Inserccion para crear el mapa inicial
	public static function storedLatLng($conexion, $idUser, $lat, $lng){
		$insertada = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "INSERT INTO mapConfigure (locationAllow, latPosition, lngPosition, zoom, type, minMarkers, maxMarkers, timeStamp, idUser)  VALUES (1, :latPosition, :lngPosition, 14, 'roadmap', 0, 1000, NOW(), :idUser) ";
				$sentencia = $conexion->prepare( $sql );					
				$sentencia->bindParam( ':latPosition', $lat, PDO::PARAM_STR );
				$sentencia->bindParam( ':lngPosition',$lng, PDO::PARAM_STR );
				$sentencia->bindParam( ':idUser', $idUser, PDO::PARAM_INT );
				$insertada = $sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $insertada;		
	}
	/******************FIN DE ISERT*******************************************/
	/**********************UPDATE*********************************************/
	
	public static function updateLatLng($conexion, $mapConfigure){
		$actualizada = false;
		//$validada=10;
		if ( isset( $conexion ) ) {
			try {
				$sql = "UPDATE mapConfigure SET latPosition=:latPosition, lngPosition=:lngPosition WHERE id = :id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $mapConfigure->getId(), PDO::PARAM_INT );
				$sentencia->bindParam( ':latPosition', $mapConfigure->getLatPosition(), PDO::PARAM_STR);
				$sentencia->bindParam( ':lngPosition', $mapConfigure->getLngPosition(), PDO::PARAM_STR);
				$sentencia->execute();
				$resultado =$sentencia->rowCount();
				if(count($resultado)){
					$actualizada=true;
				}else{
					$actualizada=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $actualizada;
	}
	public static function updateZoom($conexion, $zoom){
		require_once('ControlSesion.php');
		$zoomAntiguo=null;
		$idMap=null;
		$mapConfigure=RepositorioMapConfigure::getMapaDeUnUsuario($conexion,ControlSesion::getNameUsuario());
		if($mapConfigure!=null){
			$zoomAntiguo=$mapConfigure->getZoom();
			$idMap=$mapConfigure->getId();
		}
		$actualizada = false;
		if ( isset( $conexion ) ) {
			try {
				//1.Obtenemos el mapa del usuario
				$sql = "UPDATE mapConfigure SET zoom=:zoom WHERE id = :id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $idMap, PDO::PARAM_INT );
				$sentencia->bindParam( ':zoom', $zoom, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado =$sentencia->rowCount();
				if(count($resultado)){
					$actualizada=true;
				}else{
					$actualizada=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		/*echo "<h1>El mapa ".$idMap.", del usuario: ".ControlSesion::getNameUsuario().", se ha actualizado el zoom de ".$zoomAntiguo." a: ".$zoom."</h1>";*/
		return $actualizada;
	}



	public static function updateMaxMarkers($conexion, $maxMarkers){
		require_once('ControlSesion.php');
		
		$idMap=null;
		$idMap=RepositorioMapConfigure::getIdMapaDeUnUsuario($conexion,ControlSesion::getNameUsuario());
		
		$actualizada = false;
		if ( isset( $conexion ) ) {
			try {
				//1.Obtenemos el mapa del usuario
				$sql = "UPDATE mapConfigure SET maxMarkers=:maxMarkers WHERE id = :id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $idMap, PDO::PARAM_INT );
				$sentencia->bindParam( ':maxMarkers', $maxMarkers, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado =$sentencia->rowCount();
				if(count($resultado)){
					$actualizada=true;
				}else{
					$actualizada=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $actualizada;
	}



	public static function updateTypeMap($conexion, $typeMap){
		require_once('ControlSesion.php');
		
		$idMap=null;
		$idMap=RepositorioMapConfigure::getIdMapaDeUnUsuario($conexion,ControlSesion::getNameUsuario());
		
		$actualizada = false;
		if ( isset( $conexion ) ) {
			try {
				//1.Obtenemos el mapa del usuario
				$sql = "UPDATE mapConfigure SET type=:type WHERE id = :id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $idMap, PDO::PARAM_INT );
				$sentencia->bindParam( ':type', $typeMap, PDO::PARAM_STR);
				$sentencia->execute();
				$resultado =$sentencia->rowCount();
				if(count($resultado)){
					$actualizada=true;
				}else{
					$actualizada=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $actualizada;
	}


	/********************FIN DE UPDATE***************************************/

	
	
	/****************DELETE**************************************************/
	public static function delete( $conexion,$id ) {
		$fueBorrada=false;
		if ( isset( $conexion ) ) {
			try {
				$sql = 'DELETE FROM mapConfigure WHERE id =:id';
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':id',$id,PDO::PARAM_INT);
				$fueBorrada=$sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueBorrada;
	}

	public static function deleteMapaFromUser($conexion, $idUser){
		$fueBorradoElMapa=false;
		if ( isset( $conexion ) ) {
			try {
				//echo "Entra";
				$sql = 'DELETE FROM mapConfigure WHERE idUser =:idUser';
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':idUser',$idUser,PDO::PARAM_STR);
				$fueBorradoElMapa=$sentencia->execute();
				
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueBorradoElMapa;
	}
	
	
	/****************FIN DELETE**********************************************/
} //Fin de la clase con métodos estáticos

?>

