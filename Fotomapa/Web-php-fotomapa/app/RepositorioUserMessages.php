<?php
class RepositorioUserMessages {

	function __construct() {}

	/*******************************SELECT*****************************/
	/*public static function hayMensajes( $conexion,$userName ) {
		$hay = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT count() FROM usermessages WHERE userName=:userName LIMIT 1";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':userName',$userName,PDO::PARAM_STR);
				$sentencia->execute();
				$linea=$sentencia->fetch();
				if(count($linea)){
					$hay=true;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $hay;
	}*/
	public static function get( $conexion,$userName ) {
		$menssage = '';
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT message FROM usermessages WHERE userName=:userName LIMIT 1";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':userName',$userName,PDO::PARAM_STR);
				$sentencia->execute();
				$linea=$sentencia->fetch();
				if(count($linea)){
					$message = $linea[ 'message' ];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $message;
	}
	/*******************************FIN DE SELECT*******************************/
	/***********************INSERT********************************************/
	public static function stored($conexion, $message, $userName){
		$fueInsertada = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "INSERT INTO usermessages (message, userName)  VALUES (:message, :userName) ";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':message', $message, PDO::PARAM_STR );
				$sentencia->bindParam( ':userName', $userName, PDO::PARAM_STR );
				$fueInsertada = $sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueInsertada;		
	}
	/******************FIN DE ISERT*******************************************/
	
	
	/****************DELETE**************************************************/
	public static function delete( $conexion,$userName ) {
		$fueBorrada=false;
		if ( isset( $conexion ) ) {
			try {
				$sql = 'DELETE FROM usermessages WHERE userName =:userName';
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':userName',$userName,PDO::PARAM_STR);
				$fueBorrada=$sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueBorrada;
	}
	
	
	/****************FIN DELETE**********************************************/
} //Fin de la clase con métodos estáticos

?>

