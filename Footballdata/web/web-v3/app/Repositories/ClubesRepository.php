<?php
namespace App\Repositories;

use App\Libraries\SQLiteClient;
use Exception;
class ClubesRepository{
    private $sqliteCient;
    public function __construct(){
        $this->sqliteCient = new SQLiteClient();
    }
    public function __destruct(){
        if ($this->sqliteCient) {
            $this->sqliteCient->close();
        }
    }
    public function getAllClubes($order, $init)
    {
        $clubes=[];
        try {
            
            // $result = $this->sqliteCient->query("SELECT * FROM players ORDER BY ".$order." LIMIT ".$init.", 10 ");
            //$result = $this->sqliteCient->query("SELECT * FROM clubs");
            $result = $this->sqliteCient->query("SELECT * FROM clubs ORDER BY ".$order." LIMIT ".$init.", 10 ");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $clubes[]= $row;
            }

        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $clubes;     
    }

    public function getCountClubes(){
        $rowCount=0;
        try {
            $result = $this->sqliteCient->query("SELECT count(*) FROM clubs");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rowCount =  $row['count(*)'];
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
        return $rowCount;
    }

    public function getClubesBySearch($search, $field, $order, $init){
        $clubes=[];
        try {
            $result = $this->sqliteCient->query("SELECT * FROM clubs WHERE ".$field." LIKE '%".$search."%' ORDER BY ".$order." LIMIT ".$init.", 10 ");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $clubes[]= $row;
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
        return $clubes;
    }

    public function countClubesBySearch($search, $field){
        $rowCount=0;
        try {
            $result = $this->sqliteCient->query("SELECT count(*) FROM clubs WHERE ".$field." LIKE '%".$search."%'");
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