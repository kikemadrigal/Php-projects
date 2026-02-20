<?php
//`id`, `nombre`, `datos`
class RepositorioClientesComandos {
    public static function obtenerTodosLosClienteComandos($conexion){
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT * FROM clientesComandos";
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

    public static function mostrarUnClienteComando( $conexion,$id ) {
        //echo "pasa por mostrar clienet";
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT * FROM clientesComandos WHERE id=:id LIMIT 1";
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
    public static function mostrarLosClientesComandosDeUnCliente( $conexion,$idCliente ) {
        //echo "pasa por mostrar comandos de un cliente";
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT * FROM clientesComandos WHERE idCliente=:idCliente";
                $sentencia=$conexion->prepare($sql);
                $sentencia->bindParam(':idCliente',$idCliente,PDO::PARAM_INT);
                $sentencia->execute();
                $linea=$sentencia->fetchAll();
                //echo "obtenidos: ".count($linea);
                return $linea;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
            }
        }
    }

    public static function mostrarLosClientesComandosConNombreDeUnCliente( $conexion,$idCliente ) {
        //echo "pasa por mostrar comandos de un cliente";
        if ( isset( $conexion ) ) {
            try {
                $sql = "Select cc.id, cc.idCliente, cc.idComando, co.nombre from clientesComandos cc INNER JOIN comandos co ON cc.idComando=co.id where cc.idCliente=:idCliente";
                $sentencia=$conexion->prepare($sql);
                $sentencia->bindParam(':idCliente',$idCliente,PDO::PARAM_INT);
                $sentencia->execute();
                $linea=$sentencia->fetchAll();
                //echo "obtenidos: ".count($linea);
                return $linea;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
            }
        }
    }


    public static function crearClientesComando($conexion, $idCliente, $idComando){
        $insertadaFoto = false;
        if ( isset( $conexion ) ) {
            try {
                $sql = "INSERT INTO clientesComandos (idCliente, idComando)  VALUES (:idCliente, :idComando) ";
                $sentencia = $conexion->prepare( $sql );
                $sentencia->bindParam( ':idCliente', $idCliente, PDO::PARAM_INT );
                $sentencia->bindParam( ':idComando', $idComando, PDO::PARAM_INT );
                $insertadoComando = $sentencia->execute();
                $insertadaComando=true;
                return $insertadaComando;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
                return $insertadaComando;
            }
        }	
    }


    public static function actualizarClientesComando($conexion, $id, $idCliente, $idComando){
        $actualizadaFoto = false;
        if ( isset( $conexion ) ) {
            try {
                $sql = "UPDATE clientesComandos SET idCliente=:idCliente, idComando=:idComando WHERE id =:id";
                $sentencia = $conexion->prepare( $sql );
                $sentencia->bindParam( ':id', $id, PDO::PARAM_INT );
                $sentencia->bindParam( ':idCliente', $idCliente, PDO::PARAM_INT );
                $sentencia->bindParam( ':idComando', $idComando, PDO::PARAM_INT );
                $sentencia->execute();
                $resultadoOK =$sentencia->rowCount();
                return $resultadoOK;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
                return $resultadoOK;
            }
        }
    }

    public static function eliminarClientesComando( $conexion,$id ) {
        $fueronBorradas=false;
        if ( isset( $conexion ) ) {
            try {
                $sql = 'DELETE FROM clientesComandos WHERE id =:id';
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