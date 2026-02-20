<?php
class RepositorioUsuario {
	function __construct() {}


	
	/*****Insert**********/
	public static function stored( $conexion, $usuario ) {
		//require('Usuario.php');
		$insertadoUsuario = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "INSERT INTO usuarios (nombre, clave, tipo, correo, nombrereal, apellidos, web, validado, contador,fecha)  VALUES (:nombre, :clave, :tipo, :correo, :nombreReal, :apellidos, :web, :validado, :contador, NOW()) ";
				$sentencia = $conexion->prepare( $sql );
				//Tenemos que indica el valor de los parámetros con el métdo bind ara enlazar parámetro
				//1.Le indicamos que parametro que queremos enlazar, 2 que valor va a tener el parámetro, 3 tenemos que indicar de que tipo es este parámetro
				$sentencia->bindParam( ':nombre', $usuario->getNombre(), PDO::PARAM_STR );
				$sentencia->bindParam( ':clave', $usuario->getClave(), PDO::PARAM_STR );
				$sentencia->bindParam( ':tipo', $usuario->getTipo(), PDO::PARAM_STR );
				$sentencia->bindParam( ':correo', $usuario->getCorreo(), PDO::PARAM_STR );
				$sentencia->bindParam( ':nombreReal', $usuario->getNombreReal(), PDO::PARAM_STR );
				$sentencia->bindParam( ':apellidos', $usuario->getApellidos(), PDO::PARAM_STR );
				$sentencia->bindParam( ':web', $usuario->getWeb(), PDO::PARAM_STR );
				$sentencia->bindParam( ':validado', $usuario->getValidado(), PDO::PARAM_INT );
				$sentencia->bindParam( ':contador', $usuario->getContador(), PDO::PARAM_INT );
				//$sentencia->bindParam( ':datos', $usuario->getDatos(), PDO::PARAM_STR );
				$insertadoUsuario = $sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $insertadoUsuario;
	}
	/********
	***Select
	*********/

	public static function comprobarSiExisteNombre( $conexion, $nombre ) {
		$existeNombre = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios WHERE nombre=:nombre";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':nombre',$nombre,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetchAll();
				if(count($resultado)){
					$existeNombre=true;
				}else{
					$existeNombre=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $existeNombre;
	}
	public static function comprobarSiExisteId( $conexion, $id ) {
		$existeId = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios WHERE id=:id";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':id',$id,PDO::PARAM_INT);
				$sentencia->execute();
				$resultado=$sentencia->fetchAll();
				if(count($resultado)){
					$existeId=true;
				}else{
					$existeId=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $existeId;
	}
	public static function comprobarSiExisteEmail( $conexion, $correo ) {
		$existeCorreo = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios WHERE correo=:correo";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':correo',$correo,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetchAll();
				if(count($resultado)){
					$existeCorreo=true;
				}else{
					$existeCorreo=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $existeCorreo;
	}

	public static function obtener_usuario_por_nombre($conexion,$nombre){
		$usuario=null;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios WHERE nombre=:nombre";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':nombre',$nombre,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if(count($resultado)){
					$usuario=new Usuario($resultado['id'],
										 $resultado['nombre'],
										 $resultado['clave'],
										 $resultado['tipo'],
										 $resultado['correo'],
										 $resultado['nombrereal'],
										 $resultado['apellidos'],
										 $resultado['web'],
										 $resultado['validado'],
										 $resultado['contador'],
										 $resultado['fecha'],
										 $resultado['datos'] );
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $usuario;
	}
	public static function obtener_usuario_por_email_api($conexion,$email){
		$usuario=null;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios WHERE correo=:email";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':email',$email,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				return $resultado;
				/*if(count($resultado)){
					$usuario=new Usuario($resultado['id'],
										 $resultado['nombre'],
										 $resultado['clave'],
										 $resultado['tipo'],
										 $resultado['correo'],
										 $resultado['nombrereal'],
										 $resultado['apellidos'],
										 $resultado['web'],
										 $resultado['validado'],
										 $resultado['contador'],
										 $resultado['fecha'],
										 $resultado['datos'] );
				}*/
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		//return $usuario;
	}

	public static function obtener_usuario_por_email_api_con_objeto($conexion,$email){
		$usuario=null;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios WHERE correo=:email";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':email',$email,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();

				if(count($resultado)){
					$usuario=new Usuario($resultado['id'],
										 $resultado['nombre'],
										 $resultado['clave'],
										 $resultado['tipo'],
										 $resultado['correo'],
										 $resultado['nombrereal'],
										 $resultado['apellidos'],
										 $resultado['web'],
										 $resultado['validado'],
										 $resultado['contador'],
										 $resultado['fecha'],
										 $resultado['datos'] );
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $usuario;
	}
	
	public static function obtener_id_usuario_por_nombre($conexion,$nombre){
		$idUsuario=null;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios WHERE nombre=:nombre";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':nombre',$nombre,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if(count($resultado)){
					$idUsuario=$resultado['id'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $idUsuario;
	}
	//Función utilizada en showall para ver si es el creador de la foto
	public static function obtener_nombre_de_usuario_por_id($conexion,$id){
		$nombre=null;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT nombre FROM usuarios WHERE id=:id";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':id',$id,PDO::PARAM_INT);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if(count($resultado)){
					$nombre=$resultado['nombre'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $nombre;
	}
	public static function obtener_usuario_por_email($conexion,$email){
		$usuario=null;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios WHERE correo=:email";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':email',$email,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if(count($resultado)){
					$usuario=new Usuario($resultado['id'],
										 $resultado['nombre'],
										 $resultado['clave'],
										 $resultado['tipo'],
										 $resultado['correo'],
										 $resultado['nombrereal'],
										 $resultado['apellidos'],
										 $resultado['web'],
										 $resultado['validado'],
										 $resultado['contador'],
										 $resultado['fecha'],
										 $resultado['datos'] );
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $usuario;
	}
	public static function obtener_tipo_por_nombre($conexion,$nombre){
		$tipo='';
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT tipo FROM usuarios WHERE nombre=:nombre";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':nombre',$nombre,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if(count($resultado)){
					$tipo=$resultado['tipo'];						 
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $tipo;
	}
	//Obtener el total de usuarios para el administrador
	public static function getTotal($conexion) {
		$total=0;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT COUNT(*) as total FROM usuarios";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if ( count( $resultado ) ) {
					$total=$resultado['total'];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $total;
	}
	public static function getAllAPI($conexion) {
		
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM usuarios";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->execute();
				$resultado=$sentencia->fetchAll();
				return $resultado;
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
	
	}
	/******Fin de select***************/
	/******************UPDATE*************************/
	public static function actualizarClaveUsuario($conexion, $idUsuario, $nuevaClave){
		$actualizadoUsuario = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "UPDATE usuarios SET clave = :clave WHERE id = :id";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':id', $idUsuario, PDO::PARAM_INT );
				$sentencia->bindParam( ':clave', $nuevaClave, PDO::PARAM_STR );
				$sentencia->execute();
				//El método rowCount() nos dice cuantas filas de la tabla se hn actualizado
				$resultado =$sentencia->rowCount();
				if(count($resultado)){
					$actualizadoUsuario=true;
				}else{
					$actualizadoUsuario=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $actualizadoUsuario;
	}
	
	
	
	
	
	/**********FIN DE UPDATE*****************************/
	
	public static function generarCodigoActivacion($longitud,$especiales){
		// Array con los valores a escoger
		$semilla = array();
		$semilla[] = array('a','e','i','o','u');
		$semilla[] = array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z');
		$semilla[] = array('0','1','2','3','4','5','6','7','8','9');
		$semilla[] = array('A','E','I','O','U');
		$semilla[] = array('B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z');
		$semilla[] = array('0','1','2','3','4','5','6','7','8','9');
 
		// si puede contener caracteres especiales, aumentamos el array $semilla
		if ($especiales) { 
			$semilla[] = array('$','#','%','&amp;','@','-','?','¿','!','¡','+','-','*');
		}
 
		// creamos la clave con la longitud indicada
		for ($bucle=0; $bucle<$longitud; $bucle++)
		{
			// seleccionamos un subarray al azar
			$valor = mt_rand(0, count($semilla)-1);
			// selecccionamos una posición al azar dentro del subarray
			$posicion = mt_rand(0,count($semilla[$valor])-1);
			// cogemos el carácter y lo agregamos a la clave
			$clave .= $semilla[$valor][$posicion];
		}
		// devolvemos la clave
		return $clave;
	}
	
	/**********************************DELETE**********************************/
	/*public static function deleteUserFilesAndMap( $conexion,$usuarioMapa ) {
		$idUsuario=null;
		$idMapa=null;
		$fueBorradaElMapa=false;
		$fueBorrad0ElUsuario=false;
		if ( isset( $conexion ) ) {
			try {
				//He cambiado el motor de la base de datos de MySamm a InnoDB
				$conexion->beginTransaction();
				//1.Obtenemos la id del usuario para poder borrar el mapa y el usuario
				$sql = "SELECT id FROM usuarios WHERE nombre=:nombre";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':nombre',$usuarioMapa,PDO::PARAM_STR);
				$sentencia->execute();
				$resultado=$sentencia->fetch();
				if(count($resultado)){
					$idUsuario=$resultado['id'];
					//2.Borramos todas las fotos  y archivos de ese usuario
					$sql2 = 'DELETE FROM fotos WHERE idUser =:id';
					$sentencia=$conexion->prepare($sql);
					$sentencia->bindParam(':id',$idUsuario,PDO::PARAM_INT);
					$fueBorradasLasFotos=$sentencia->execute();
					if($fueBorradasLasFotos){
						//3.Borramos los mapas o el mapa del usuario con esa id
						$sql2 = 'DELETE FROM mapConfigure WHERE idUser =:id';
						$sentencia=$conexion->prepare($sql);
						$sentencia->bindParam(':id',$idUsuario,PDO::PARAM_INT);
						$fueBorradaElMapa=$sentencia->execute();
						if($fueBorrada){
							//4.Borramos al usuario
							$sql2 = 'DELETE FROM usuarios WHERE idUser =:idUser';
							$sentencia=$conexion->prepare($sql);
							$sentencia->bindParam(':idUser',$idUsuario,PDO::PARAM_INT);
							$fueBorrad0ElUsuario=$sentencia->execute();
							$conexion->commit();
						}
					}
					
				
				
				
			} catch ( PDOException $ex ) {
				$conexion->rollback();
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueBorrada;
	}*/
	//Borrar el usuario con el id...
	public static function deleteUser( $conexion,$id ) {
		$fueBorrado=false;
		if ( isset( $conexion ) ) {
			try {
				$sql = 'DELETE FROM usuarios WHERE id =:id';
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':id',$id,PDO::PARAM_INT);
				$fueBorrado=$sentencia->execute();
				if($fueBorrada){
					
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueBorrado;
	}
	public static function deleteUserFilesAndMap( $conexion,$usuarioMapa ) {
		$exitoAlBorrar=false;
		$fueronBorradasFotos=false;
		$fueBorradoMapa=false;
		$fueBorradoUsuario=false;
		require_once('RepositorioMapConfigure.php');
		require_once('RepositorioFotos.php');
		require_once('RepositorioUsuario.php');
		//1.obtenemos el id de usuario para poder borrar su mapa
		$idUsuario=RepositorioUsuario::obtener_id_usuario_por_nombre($conexion,$usuarioMapa);
		if($idUsuario==null){
			echo "No se obtuvo un usuario. ";
		}
		$fueronBorradasFotos=RepositorioFotos::deleteAllFromUser($conexion,$idUsuario);
		$fueBorradoMapa=RepositorioMapConfigure::deleteMapaFromUser($conexion,$idUsuario);
		$fueBorradoUsuario=RepositorioUsuario::deleteUser($conexion,$idUsuario);
		if($fueronBorradasFotos && $fueBorradoMapa && $fueBorradoUsuario){
			$exitoAlBorrar=true;
		}
		return $exitoAlBorrar;
	}



	/*************FIN DE DELETE*********************************************/
	
	
	
}
?>








































  



