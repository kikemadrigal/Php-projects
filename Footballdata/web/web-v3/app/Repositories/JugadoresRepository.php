<?php
namespace App\Repositories;
use App\Libraries\SQLiteClient;
use Exception;
class JugadoresRepository{
    private $sqliteCient;
    public function __construct(){
        $this->sqliteCient = new SQLiteClient();
    }
    public function __destruct(){
        if ($this->sqliteCient) {
            $this->sqliteCient->close();
        }
    }

    public function getAllJugadores($order, $init){
        $jugadores=[];
        try {
            $result = $this->sqliteCient->query("SELECT * FROM players ORDER BY ".$order." LIMIT ".$init.", 10 ");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $jugadores[] = $row;
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $jugadores;
    }

    public function getJugador($player_id){
        $jugador=[];
        try {
            $result = $this->sqliteCient->query("SELECT * FROM players WHERE player_id = " . $player_id);
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $jugador[] = $row;
            }
            //// Mostrar los datos
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $jugador;
    }

    public function countJugadores(){
        $rowCount=0;
        try {
            //$result = $this->sqliteCient->query("SELECT * FROM players ORDER BY player_id LIMIT ".$init.", 10 ");
            $result = $this->sqliteCient->query("SELECT count(*) FROM players");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rowCount =  $row['count(*)']; 
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $rowCount;
    }

    public function getJugadoresBySearch($search, $field, $order, $init){
        $jugadores=[];
        try {
            $result = $this->sqliteCient->query("SELECT * FROM players WHERE ".$field." LIKE '%".$search."%' ORDER BY ".$order." LIMIT ".$init.", 10 ");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $jugadores[] = $row;
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $jugadores;
    }

    public function countJugadoresBySearch($search, $field){
        $rowCount=0;
        try {
            $result = $this->sqliteCient->query("SELECT count(*) FROM players WHERE ".$field." LIKE '%".$search."%'");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rowCount =  $row['count(*)']; 
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $rowCount;
    }
    
}