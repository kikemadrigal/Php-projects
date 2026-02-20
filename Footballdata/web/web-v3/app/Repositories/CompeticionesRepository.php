<?php
namespace App\Repositories;
use App\Libraries\SQLiteClient;
use Exception;
class CompeticionesRepository{
    private $sqliteCient;
    public function __construct(){
        $this->sqliteCient = new SQLiteClient();
    }
    public function __destruct(){
        if ($this->sqliteCient) {
            $this->sqliteCient->close();
        }
    }
    public function getAllCompeticiones($order, $init)
    {
        $competiciones=[];
        try {
            $result = $this->sqliteCient->query("SELECT * FROM competitions ORDER BY ".$order." LIMIT ".$init.", 10 ");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $competiciones[]= $row;
            }

        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $competiciones;     
    }

    public function getCountCompeticiones(){
        $rowCount=0;
        try {
            $result = $this->sqliteCient->query("SELECT count(*) FROM competitions");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rowCount =  $row['count(*)'];
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
        return $rowCount;
    }

    public function getCompeticionesBySearch($search, $field, $order, $init){
        $competiciones=[];
        try {
            $result = $this->sqliteCient->query("SELECT * FROM competitions WHERE ".$field." LIKE '%".$search."%' ORDER BY ".$order." LIMIT ".$init.", 10 ");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $competiciones[]= $row;
            }
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
        return $competiciones;
    }

    public function countCompeticionesBySearch($search, $field){
        $rowCount=0;
        try {
            $result = $this->sqliteCient->query("SELECT count(*) FROM competitions WHERE ".$field." LIKE '%".$search."%'");
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