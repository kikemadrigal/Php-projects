<?php
//`id`, `nombre`, `datos`
class RepositorioComandos {
    public static function obtenerTodosLosComandos($conexion){
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT * FROM comandos";
                $sentencia=$conexion->prepare($sql);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();
                //echo "Se ha obtenido ".count($resultado);
                return $resultado;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
            }
        }
    }

    public static function mostrarUnComando( $conexion,$id ) {
        //echo "pasa por mostrar clienet";
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT * FROM comandos WHERE id=:id LIMIT 1";
                $sentencia=$conexion->prepare($sql);
                $sentencia->bindParam(':id',$id,PDO::PARAM_INT);
                $sentencia->execute();
                $linea=$sentencia->fetch();
                //echo "obtenidos: ".count($linea);
                return $linea;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
            }
        }
    }
    public static function mostrarNombreDeUnComando( $conexion,$id ) {
        //echo "pasa por mostrar clienet";
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT nombre FROM comandos WHERE id=:id LIMIT 1";
                $sentencia=$conexion->prepare($sql);
                $sentencia->bindParam(':id',$id,PDO::PARAM_INT);
                $sentencia->execute();
                $linea=$sentencia->fetch();
                //echo "obtenidos: ".count($linea);
                return $linea['nombre'];
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
            }
        }
    }



    public static function crearComando($conexion, $nombre, $datos){
        $insertadaFoto = false;
        if ( isset( $conexion ) ) {
            try {
                $sql = "INSERT INTO comandos (nombre, datos)  VALUES (:nombre, :datos) ";
                $sentencia = $conexion->prepare( $sql );
                $sentencia->bindParam( ':nombre', $nombre, PDO::PARAM_STR );
                $sentencia->bindParam( ':datos', $datos, PDO::PARAM_STR );
                $insertadoComando = $sentencia->execute();
                $insertadaComando=true;
                return $insertadaComando;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
                return $insertadaComando;
            }
        }	
    }


    public static function actualizarComando($conexion, $id, $nombre, $datos){
        $actualizadaFoto = false;
        if ( isset( $conexion ) ) {
            try {
                $sql = "UPDATE comandos SET nombre=:nombre, datos=:datos WHERE id =:id";
                $sentencia = $conexion->prepare( $sql );
                $sentencia->bindParam( ':id', $id, PDO::PARAM_INT );
                $sentencia->bindParam( ':nombre', $nombre, PDO::PARAM_STR );
                $sentencia->bindParam( ':datos', $datos, PDO::PARAM_STR );
                $sentencia->execute();
                $resultadoOK =$sentencia->rowCount();
                return $resultadoOK;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
                return $resultadoOK;
            }
        }
    }

    public static function eliminarComando( $conexion,$id ) {
        $fueronBorradas=false;
        if ( isset( $conexion ) ) {
            try {
                $sql = 'DELETE FROM comandos WHERE id =:id';
                $sentencia=$conexion->prepare($sql);
                $sentencia->bindParam(':id',$id,PDO::PARAM_INT);
                $sentencia->execute();
                if( ! $sentencia->rowCount() ) $fueronBorradas=false;
                else $fueronBorradas=true;
                return $fueronBorradas;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
                return $fueronBorradas;
            }
        }
    }



}
?>