<?php
class Conexion {
	private static $conexion;
	public static function abrir_conexion() {
		if ( !isset( self::$conexion ) ) {
			try {
				include_once( "../../config/app.inc.php" );
				self::$conexion = new PDO( 'mysql:host=' .SERVER. '; dbname=' .DATABASE, USER, PASSWORD );
				self::$conexion->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				self::$conexion->exec( "SET CHARACTER SET utf8" );
				//print("usuario ".$user.", contraseña: ".$password.", ".$dataBaseName.", ".$server);
				//print( 'Conexion abierta' );
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() . "<br>" );
				die();
			}
		}
	}
	public static function cerrar_conexion() {
		if ( isset( self::$conexion ) ) {
			self::$conexion = null;
			//print( "Conexion cerrada" );
		}
	}
	public static function obtener_conexion() {
		return self::$conexion;
	}
	public static function obtenerDrivers() {
		return PDO::getAvailableDrivers();
	}
}
?>