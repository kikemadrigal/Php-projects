<?php
//`id`, 'cif', `nombre`, `datos`
class RepositorioClientes {
    public static function obtenerTodosLosClientes($conexion){
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT * FROM clientes";
                $sentencia=$conexion->prepare($sql);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();
                //echo "Se ha obtenido ".count($resultado);
                return $resultado;
                /* if ( count( $resultado ) ) {
                    foreach ( $resultado as $linea ) {
                        echo $linea[ 'id' ].", ".$linea['cif'].", ".$linea['nombre'];
                    }
                }*/
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
            }
        }
    }
    

    public static function obtenerTodosLosClientesConElNombre($conexion, $nombre){
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT * FROM clientes WHERE nombre LIKE '%".$nombre."%'";
                $sentencia=$conexion->prepare($sql);
                //$sentencia->bindParam( ':nombre', $nombre, PDO::PARAM_STR );
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();
                //echo "Se ha obtenido ".count($resultado);
                return $resultado;
                /* if ( count( $resultado ) ) {
                    foreach ( $resultado as $linea ) {
                        echo $linea[ 'id' ].", ".$linea['cif'].", ".$linea['nombre'];
                    }
                }*/
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
            }
        }
    }
    public static function mostrarUnCliente( $conexion,$id ) {
        //echo "pasa por mostrar clienet";
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT * FROM clientes WHERE id=:id LIMIT 1";
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
    public static function mostrarNombreCliente( $conexion,$id ) {
        //echo "pasa por mostrar clienet";
        if ( isset( $conexion ) ) {
            try {
                $sql = "SELECT nombre FROM clientes WHERE id=:id LIMIT 1";
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


    public static function crearCliente($conexion, $cif, $nombre, $datos){
        $insertadaFoto = false;
        if ( isset( $conexion ) ) {
            try {
                $sql = "INSERT INTO clientes (cif, nombre, datos)  VALUES (:cif, :nombre, :datos) ";
                $sentencia = $conexion->prepare( $sql );
                $sentencia->bindParam( ':cif', $cif, PDO::PARAM_STR );
                $sentencia->bindParam( ':nombre', $nombre, PDO::PARAM_STR );
                $sentencia->bindParam( ':datos', $datos, PDO::PARAM_STR );
                $insertadoCliente = $sentencia->execute();
                $insertadaCliente=true;
                return $insertadaCliente;
            } catch ( PDOException $ex ) {
                print( "Error: " . $ex->getMessage() );
                return $insertadaCliente;
            }
        }	
    }


    public static function actualizarCliente($conexion, $id, $cif, $nombre, $datos){
        $actualizadaFoto = false;
        if ( isset( $conexion ) ) {
            try {
                $sql = "UPDATE clientes SET cif=:cif, nombre=:nombre, datos=:datos WHERE id =:id";
                $sentencia = $conexion->prepare( $sql );
                $sentencia->bindParam( ':id', $id, PDO::PARAM_INT );
                $sentencia->bindParam( ':cif', $cif, PDO::PARAM_STR );
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

    public static function eliminarCliente( $conexion,$id ) {
        $fueronBorradas=false;
        
        if ( isset( $conexion ) ) {
            try {
                $sql = 'DELETE FROM clientes WHERE id =:id';
                $sentencia=$conexion->prepare($sql);
                $sentencia->bindParam(':id',$id,PDO::PARAM_INT);
                $sentencia->execute();
                //echo "resultado <h4> ".$fueronBorradas."</h4>";
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