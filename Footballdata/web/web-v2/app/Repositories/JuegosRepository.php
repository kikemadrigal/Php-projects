<?php
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
    
    public function get_count_juegos( $where_name="",$where_value=""){
        $rowCount=0;
        try {
            if(empty( $where_name)){
                $result =  $this->sqliteCient->query("SELECT count(*) FROM games;");
            }else{
                $result =  $this->sqliteCient->query("SELECT count(*) FROM games WHERE {$where_name} LIKE '%{$where_value}%';"); 
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
    
    public function get_juegos($init=0, $where_name="",$where_value="", $order="juego_id"){
        $juegos=[];
        try {
            // Consultar los datos de la tabla
            if(empty( $where_name)){
                $result =  $this->sqliteCient->query("SELECT * FROM games ORDER BY {$order} LIMIT {$init}, 10;");
            }else{
                $result =  $this->sqliteCient->query("SELECT * FROM games WHERE {$where_name} LIKE '%{$where_value}%' ORDER BY {$order} LIMIT {$init}, 10;");
            }
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $juegos[] = $row;
            }
            $result->finalize();    
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
        return $juegos;
    } 
}