<?php
class RepositorioFotos {

	function __construct() {}

	/**************************SELECT*******************************************/
	public static function show( $conexion,$id ) {
		$foto = null;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM fotos WHERE id=:id LIMIT 1";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':id',$id,PDO::PARAM_INT);
				$sentencia->execute();
				$linea=$sentencia->fetch();
				if(count($linea)){
					//foreach ( $resultado as $linea ) {
					//$id, $name, $text, $type, $address, $city, $country, $lat, $lng, $user,$validada, $timestamp
					$foto = new Foto( $linea[ 'id' ], $linea[ 'name' ], $linea[ 'text' ], $linea[ 'type' ], $linea[ 'address' ], $linea[ 'city' ], $linea[ 'country' ], $linea[ 'lat' ], $linea[ 'lng' ], $linea[ 'user' ], $linea[ 'validada' ], $linea[ 'timestamp' ] );
					//}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $foto;
	}
	public static function showAPI( $conexion,$id ) {
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM fotos WHERE id=:id LIMIT 1";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':id',$id,PDO::PARAM_INT);
				$sentencia->execute();
				$linea=$sentencia->fetch();
				return $linea;
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
	}
	public static function obtenerCreadorDeFotoConId($conexion,$id){
		$creador = '';
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT user FROM fotos WHERE id=:id LIMIT 1";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':id',$id,PDO::PARAM_INT);
				$sentencia->execute();
				$linea=$sentencia->fetch();
				if(count($linea)){
					$creador=$linea[ 'user' ];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $creador;
	}
	
	//Obtener un array de objetos foto con todas las fotos
	public static function getAll( $conexion ) {
		$fotos = array();
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
						$foto = new Foto( $linea[ 'id' ], $linea[ 'name' ], $linea[ 'text' ], $linea[ 'type' ], $linea[ 'address' ], $linea[ 'city' ], $linea[ 'country' ], $linea[ 'lat' ], $linea[ 'lng' ], $linea[ 'user' ], $linea[ 'validada' ], $linea[ 'timeStamp' ] );
						$fotos[] = $foto;
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}else{
			echo "no hay conexion";
		}
		//echo "Se han obtenido ".count($fotos);
		return $fotos;
	}
	public static function getAllUser( $conexion,$user ) {
		require_once('ControlSesion.php');
		$fotos = array();
		if ( isset( $conexion ) ) {
			try {
				require_once( "Foto.php" );
				$sql = "SELECT * FROM fotos WHERE user=:user ORDER BY timestamp DESC";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam(':user',ControlSesion::getIdUsuario($conexion),PDO::PARAM_STR);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						//$id, $name, $text, $type, $address, $city, $country, $lat, $lng, $user,$validada, $timestamp
						$foto = new Foto( $linea[ 'id' ], $linea[ 'name' ], $linea[ 'text' ], $linea[ 'type' ], $linea[ 'address' ], $linea[ 'city' ], $linea[ 'country' ], $linea[ 'lat' ], $linea[ 'lng' ], $linea[ 'user' ], $linea[ 'validada' ], $linea[ 'timestamp' ] );
						$fotos[] = $foto;
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fotos;
	}
	public static function getAllArray( $conexion, $maxMarkers ) {
		$fotos = array();
		if ( isset( $conexion ) ) {
			try {
				require_once( "Foto.php" );
				$sql = "SELECT * FROM fotos LIMIT ".$maxMarkers;
				$sentencia = $conexion->prepare( $sql );
				//$sentencia->bindParam(':maxMarkers',$maxMarkers,PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						//$id, $name, $text, $type, $address, $city, $country, $lat, $lng, $user,$validada, $timestamp
						$arrayFoto = array( "id" => $linea[ 'id' ], "name" => $linea[ 'name' ], "text" => $linea[ 'address' ], "type" => $linea[ 'type' ], "city" => $linea[ 'city' ], "country" => $linea[ 'country' ], "lat" => $linea[ 'lat' ], "lng" => $linea[ 'lng' ], "user" => $linea[ 'user' ], "validada" => $linea[ 'validada' ], "timeStamp" => $linea[ 'timeStamp' ] );
						$fotos[] = $arrayFoto;
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fotos;
	}
	public static function getAllAPI( $conexion, $maxMarkers ) {
		if ( isset( $conexion ) ) {
			try {
				require_once( "Foto.php" );
				$sql = "SELECT * FROM fotos LIMIT ".$maxMarkers;
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				
				return $resultado;
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
	}
	public static function getWithName( $conexion,$name ) {
		$foto=null;
		$fotos=array();
		if ( isset( $conexion ) ) {
			try {
				require_once( "Foto.php" );
				$sql = "SELECT * FROM fotos WHERE name LIKE '%".$name."%' ";
				$sentencia = $conexion->prepare( $sql );
				//$sentencia->bindParam(':name',$name,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						$foto = new Foto( $linea[ 'id' ], $linea[ 'name' ], $linea[ 'text' ], $linea[ 'type' ], $linea[ 'address' ], $linea[ 'city' ], $linea[ 'country' ], $linea[ 'lat' ], $linea[ 'lng' ], $linea[ 'user' ], $linea[ 'validada' ], $linea[ 'timestamp' ] );
						$fotos[] = $foto;
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fotos;
	}
	public static function getAllArrayUser( $conexion,$user ) {
		require_once('ControlSesion.php');
		$fotos = array();
		if ( isset( $conexion ) ) {
			try {
				require_once( "Foto.php" );
				$sql = "SELECT * FROM fotos WHERE user=".ControlSesion::getIdUsuario($conexion);
				$sentencia = $conexion->prepare( $sql );
				//$sentencia->bindParam(':user','IP:89.141.210.117',PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						//echo $linea['name'];
						$arrayFoto = array( "id" => $linea[ 'id' ], "name" => $linea[ 'name' ], "text" => $linea[ 'address' ], "type" => $linea[ 'type' ], "city" => $linea[ 'city' ], "country" => $linea[ 'country' ], "lat" => $linea[ 'lat' ], "lng" => $linea[ 'lng' ], "user" => $linea[ 'user' ], "validada" => $linea[ 'validada' ], "timestamp" => $linea[ 'timestamp' ] );
						$fotos[] = $arrayFoto;
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fotos;
	}
	//Numero total de fotos de un usuario
	public static function getTotalWithNameUser( $conexion,$nameUser ) {
		$totalFotos=0;
		if ( isset( $conexion ) ) {
			try {
				require_once( "Foto.php" );
				$sql = "SELECT COUNT(*) as total FROM fotos WHERE user=:nameUser";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam(':nameUser',$nameUser,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				//echo "<h2>Se han obtenido de ".$nameUser.": ".$resultado['total']."</h2>";
				if ( count( $resultado ) ) {
					$totalFotos=$resultado['total'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $totalFotos;
	}
	//Obtener el total de fotos no validadas
	public static function getTotalValidatesWithNameUser( $conexion,$nameUser ) {
		$totalFotos=0;
		if ( isset( $conexion ) ) {
			try {
				require_once( "Foto.php" );
				$sql = "SELECT COUNT(*) as total FROM fotos WHERE user=:nameUser AND validada=0";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam(':nameUser',$nameUser,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if ( count( $resultado ) ) {
					$totalFotos=$resultado['total'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $totalFotos;
	}
	//Obtener el total de fotos no validadas
	public static function getTotalNotValidatesWithNameUser( $conexion,$nameUser ) {
		$totalFotos=0;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT COUNT(*) as total FROM fotos WHERE user=:nameUser AND validada=1";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam(':nameUser',$nameUser,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if ( count( $resultado ) ) {
					$totalFotos=$resultado['total'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $totalFotos;
	}
	//Obtener el total de fotos para el administrador
	public static function getTotal( $conexion) {
		$totalFotos=0;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT COUNT(*) as total FROM fotos";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if ( count( $resultado ) ) {
					$totalFotos=$resultado['total'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $totalFotos;
	}
	//Obtener el total de fotos no validadas de usuarios registrados para el administrador
	public static function getTotalNotValidateRegisterUser( $conexion) {
		$totalFotos=0;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT COUNT(*) as total FROM fotos WHERE validada=0";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if ( count( $resultado ) ) {
					$totalFotos=$resultado['total'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $totalFotos;
	}
	//Obtener un array de fotos con fotos no validadas de usuarios registrados para el administrador
	public static function getArrayPhotosNotValidateResgisterUser($conexion) {
		$fotos=array();
		if ( isset( $conexion ) ) {
			try {
				require_once('app/Foto.php');
				$sql = "SELECT * FROM fotos WHERE validada=0";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado=$sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						$foto = new Foto( $linea[ 'id' ], $linea[ 'name' ], $linea[ 'text' ], $linea[ 'type' ], $linea[ 'address' ], $linea[ 'city' ], $linea[ 'country' ], $linea[ 'lat' ], $linea[ 'lng' ], $linea[ 'user' ], $linea[ 'validada' ], $linea[ 'timestamp' ] );
						$fotos[] = $foto;
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}else{
			echo "<h2>La conexion no existe</h2>";
		}
		return $fotos;
	}
	//Obtener el total de fotos no validadas de usuarios anonimos para el administrador
	//Las fotos no validadas de usuarios anónimos tienen un valor de 1
	public static function getTotalNotValidateAnonymousUser( $conexion) {
		$totalFotos=0;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT COUNT(*) as total FROM fotos WHERE validada=1";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if ( count( $resultado ) ) {
					$totalFotos=$resultado['total'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $totalFotos;
	}
	//Obtener un array con las fotos de anonimos no validadas
	public static function getArrayPhotosNotValidateAnonimousUser($conexion) {
		$fotos=array();
		if ( isset( $conexion ) ) {
			try {
				require_once('app/Foto.php');
				$sql = "SELECT * FROM fotos WHERE validada=1";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado=$sentencia->fetchAll();
				if ( count( $resultado ) ) {
					foreach ( $resultado as $linea ) {
						$foto = new Foto( $linea[ 'id' ], $linea[ 'name' ], $linea[ 'text' ], $linea[ 'type' ], $linea[ 'address' ], $linea[ 'city' ], $linea[ 'country' ], $linea[ 'lat' ], $linea[ 'lng' ], $linea[ 'user' ], $linea[ 'validada' ], $linea[ 'timestamp' ] );
						$fotos[] = $foto;
					}
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}else{
			echo "<h2>La conexion no existe</h2>";
		}
		return $fotos;
	}
	
	/***********************************FIN DE SELECT***************************/
	
	
	/***********************INSERT********************************************/
	public static function stored($conexion, $foto){
		$insertadaFoto = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "INSERT INTO fotos (name, text, type, address, city, country, lat, lng, user, validada, timestamp)  VALUES (:name, :text, :type, :address, :city, :country, :lat, :lng, :user, :validada, :timestamp) ";
				$sentencia = $conexion->prepare( $sql );
				//Tenemos que indica el valor de los parámetros con el métdo bind ara enlazar parámetro
				//1.Le indicamos que parametro que queremos enlazar, 2 que valor va a tener el parámetro, 3 tenemos que indicar de que tipo es este parámetro
				$sentencia->bindParam( ':name', $foto->getName(), PDO::PARAM_STR );
				$sentencia->bindParam( ':text', $foto->getText(), PDO::PARAM_STR );
				$sentencia->bindParam( ':type', $foto->getType(), PDO::PARAM_STR );
				$sentencia->bindParam( ':address', $foto->getAddress(), PDO::PARAM_STR );
				$sentencia->bindParam( ':city', $foto->getCity(), PDO::PARAM_STR );
				$sentencia->bindParam( ':country', $foto->getCountry(), PDO::PARAM_STR );
				$sentencia->bindParam( ':lat', $foto->getLat(), PDO::PARAM_STR );
				$sentencia->bindParam( ':lng', $foto->getLng(), PDO::PARAM_STR );
				$sentencia->bindParam( ':user', $foto->getUser(), PDO::PARAM_STR );
				$sentencia->bindParam( ':validada', $foto->getValidada(), PDO::PARAM_STR);
				$sentencia->bindParam( ':timestamp', $foto->getTimeStamp(), PDO::PARAM_STR );
				$insertadaFoto = $sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $insertadaFoto;		
	}
	/******************FIN DE ISERT*******************************************/
		/******************UPDATE*************************/
	public static function actualizarFoto($conexion, $foto){
		$actualizadaFoto = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "UPDATE fotos SET name=:name, text=:text, type=:type, address=:address, city=:city, country=:country, lat=:lat, lng=:lng, user=:user, validada=:validada, timeStamp=:timeStamp WHERE id = :id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $foto->getId(), PDO::PARAM_INT );
				$sentencia->bindParam( ':name', $foto->getName(), PDO::PARAM_STR );
				$sentencia->bindParam( ':text', $foto->getText(), PDO::PARAM_STR );
				$sentencia->bindParam( ':type', $foto->getType(), PDO::PARAM_STR );
				$sentencia->bindParam( ':address', $foto->getAddress(), PDO::PARAM_STR );
				$sentencia->bindParam( ':city', $foto->getCity(), PDO::PARAM_STR );
				$sentencia->bindParam( ':country', $foto->getCountry(), PDO::PARAM_STR );
				$sentencia->bindParam( ':lat', $foto->getLat(), PDO::PARAM_STR );
				$sentencia->bindParam( ':lng', $foto->getLng(), PDO::PARAM_STR );
				$sentencia->bindParam( ':user', $foto->getUser(), PDO::PARAM_STR );
				$sentencia->bindParam( ':validada', $foto->getValidada(), PDO::PARAM_STR);
				$sentencia->bindParam( ':timeStamp', $foto->getTimeStamp(), PDO::PARAM_STR );
				$sentencia->execute();
				//El método rowCount() nos dice cuantas filas de la tabla se hn actualizado
				$resultado =$sentencia->rowCount();
				if(count($resultado)){
					$actualizadaFoto=true;
				}else{
					$actualizadaFoto=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $actualizadaFoto;
	}
	
	public static function actualizarValidacionFoto($conexion, $idFoto){
		$actualizadaFoto = false;
		$validada=10;
		if ( isset( $conexion ) ) {
			try {
				$sql = "UPDATE fotos SET validada=:validada WHERE id = :id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $idFoto, PDO::PARAM_INT );
				$sentencia->bindParam( ':validada', $validada, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado =$sentencia->rowCount();
				if(count($resultado)){
					$actualizadaFoto=true;
				}else{
					$actualizadaFoto=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $actualizadaFoto;
	}
	
	
	
	/**********FIN DE UPDATE*****************************/
	
	
	/****************DELETE**************************************************/
	//public static function deleteFileFromUser($conexion, $idFoto){
		//$foto=this->show($conexion,$idFoto);
		//unlink('resources/imagesusers/'+$foto->getName()+'/foto/'+$foto->getIdUser());
	//}


	//Borrar la foto con el id...
	public static function delete( $conexion,$id ) {
		$fueBorrada=false;
		if ( isset( $conexion ) ) {
			try {
				$sql = 'DELETE FROM fotos WHERE id =:id';
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':id',$id,PDO::PARAM_INT);
				$fueBorrada=$sentencia->execute();
				if($fueBorrada){
					
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueBorrada;
	}
	

	//Borrar todas las fotos de un usuario
	public static function deleteAllFromUser( $conexion,$idUser ) {
		$fueronBorradas=false;
		if ( isset( $conexion ) ) {
			try {
				//1.Obtenemos todas las fotos y borramos los archivos

				//2.Las borramos de la base de datos
				$sql = 'DELETE FROM fotos WHERE user =:idUser';
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':idUser',$idUser,PDO::PARAM_INT);
				$fueronBorradas=$sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueronBorradas;
	}
	
	/****************FIN DELETE**********************************************/
} //Fin de la clase con métodos estáticos

?>

