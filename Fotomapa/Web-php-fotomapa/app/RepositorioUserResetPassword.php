<?php
class RepositorioUserResetPassword {

	function __construct() {}

	/*******************************SELECT*****************************/
	//Obtenemos el id del usurio através de la clave de activación generada automáticamente y que hemos 
	//almacenado en la tabla userrestpassword
	public static function get( $conexion,$passwordactivation ) {
		$userId = null;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT userId FROM userresetpassword WHERE passwordactivation=:passwordactivation LIMIT 1";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':passwordactivation',$passwordactivation,PDO::PARAM_INT);
				$sentencia->execute();
				$linea=$sentencia->fetch();
				if(count($linea)){
					$userId = $linea[ 'userId' ];
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $userId;
	}
	public static function claveActivacionExiste( $conexion,$claveActivacion ) {
		$claveExiste = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "SELECT * FROM userresetpassword WHERE passwordactivation=:passwordactivation";
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':passwordactivation',$claveActivacion,PDO::PARAM_INT);
				$sentencia->execute();
				$linea=$sentencia->fetchAll();
				if(count($linea)){
					$claveExiste=true;
				}else{
					$claveExiste=false;
				}
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $claveExiste;
	}
	/*******************************FIN DE SELECT*******************************/
	/***********************INSERT********************************************/
	public static function stored($conexion, $passwordactivation, $userId){
		$fueInsertada = false;
		if ( isset( $conexion ) ) {
			try {
				$sql = "INSERT INTO userresetpassword (passwordactivation, userId)  VALUES (:passwordactivation, :userId) ";
				$sentencia = $conexion->prepare( $sql );
				$sentencia->bindParam( ':passwordactivation', $passwordactivation, PDO::PARAM_STR );
				$sentencia->bindParam( ':userId', $userId, PDO::PARAM_INT );
				$fueInsertada = $sentencia->execute();
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() );
			}
		}
		return $fueInsertada;		
	}
	/******************FIN DE ISERT*******************************************/
	
	
	/****************DELETE**************************************************/
	public static function delete( $conexion,$userId ) {
		$fueBorrada=false;
		if ( isset( $conexion ) ) {
			try {
				$sql = 'DELETE FROM userresetpassword WHERE userId =:userId';
				$sentencia=$conexion->prepare($sql);
				$sentencia->bindParam(':userId',$userId,PDO::PARAM_INT);
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

