<?php
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
    public function get_count_clubes( $where_name="",$where_value=""){
        $rowCount=0;
        try {
            if(empty( $where_name)){
                $result =  $this->sqliteCient->query("SELECT count(*) FROM clubs;");
            }else{
                $result =  $this->sqliteCient->query("SELECT count(*) FROM clubs WHERE {$where_name} LIKE '%{$where_value}%';"); 
            }
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rowCount =  $row['count(*)']; 
            }
            $result->finalize();    
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $rowCount;
    }
    
    public function get_clubes($init=0, $where_name="",$where_value="", $order="club_id"){
        $clubes=[];
        try {
            // Consultar los datos de la tabla
            if(empty( $where_name)){
                $result =  $this->sqliteCient->query("SELECT * FROM clubs ORDER BY {$order} LIMIT {$init}, 10;");
            }else{
                $result =  $this->sqliteCient->query("SELECT * FROM clubs WHERE {$where_name} LIKE '%{$where_value}%' ORDER BY {$order} LIMIT {$init}, 10;");
            }
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $clubes[] = $row;
            }
            $result->finalize();    
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $clubes;
    } 

}