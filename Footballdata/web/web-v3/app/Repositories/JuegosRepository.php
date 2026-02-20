<?php
namespace App\Repositories;

use App\Libraries\SQLiteClient;
use Exception;
class JuegosRepository{
    private $sqliteCient;
    public function __construct(){
        $this->sqliteCient = new SQLiteClient();
    }
    public function __destruct(){
        if ($this->sqliteCient) {
            $this->sqliteCient->close();
        }
    }
    public function getAllJuegos($order, $init)
    {
        $juegos=[];
        try {
            $result = $this->sqliteCient->query("SELECT * FROM games ORDER BY ".$order." LIMIT ".$init.", 10 ");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $juegos[]= $row;
            }

        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $juegos;     
    }

    public function getCountJuegos(){
        $rowCount=0;
        try {
            $result = $this->sqliteCient->query("SELECT count(*) FROM games");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rowCount =  $row['count(*)'];
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
        return $rowCount;
    }

    public function getJuegosBySearch($search, $field, $order, $init){
        $juegos=[];
        try {
            $result = $this->sqliteCient->query("SELECT * FROM games WHERE ".$field." LIKE '%".$search."%' ORDER BY ".$order." LIMIT ".$init.", 10 ");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $juegos[]= $row;
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
        return $juegos;
    }

    public function countJuegosBySearch($search, $field){
        $rowCount=0;
        try {
            $result = $this->sqliteCient->query("SELECT count(*) FROM games WHERE ".$field." LIKE '%".$search."%'");
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