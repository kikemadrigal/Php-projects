<?php
class Conexion {
	private static $conexion;
	public static function abrir_conexion() {
		if ( !isset( self::$conexion ) ) {
			try {
				self::$conexion = new PDO( 'mysql:host=' .SERVER. '; dbname=' .DATABASE, USER, PASSWORD );
				self::$conexion->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				self::$conexion->exec( "SET CHARACTER SET utf8" );
				//print("usuario ".USER.", contraseña: ".PASSWORD.", ".DATABASE.", ".SERVER);
				//print( 'Conexion abierta' );
			} catch ( PDOException $ex ) {
				print( "Error: " . $ex->getMessage() . "<br>" );
				//die();
				echo "<h1>Servidor: ".SERVER.", user".USER.", passeord".PASSWORD.", ".DATABASE."</h1>";
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