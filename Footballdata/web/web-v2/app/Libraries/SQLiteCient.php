<?php
class SQLiteClient {
    public $sqlite;
    public $result;
    function __construct(){
        try {
            // Conectar a la base de datos SQLite3
            $this->sqlite = new SQLite3("football-data.sqlite");        
        } catch (Exception $e) {
            // En caso de error, mostrar el mensaje
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        } 
    }
    public function query($sql){
        $this->result = $this->sqlite->query($sql);
        if (!$this->result) {
			echo "<p>Error al ejecutar la consulta</p>";
			$this->result=NULL;
		}
		return $this->result;
    }
	public function getTables(){
		$tables=array();
		$resultado = $this->sqlite->query("SHOW TABLES");
        while ($linea = $resultado->fetchArray(SQLITE3_ASSOC)) {
			$tables[]= $linea[0];
		}
		return $tables;
	}

	public function checkExitsToursTable($table_to_found){
		$tables=$this->getTables();
		foreach($tables as $posicion=>$table){
			if ($table==$table_to_found || $table== strtoupper($table_to_found)){
				return true;
			}
		}
		return false;
	}
    function close(){
        if ($this->sqlite) {
            $this->sqlite->close(); 
        }
    }
    function dropDatabase(){
        $tables=$this->getTables();
        foreach($tables as $posicion=>$table){
            $this->sqlite->exec("DROP TABLE ".$table);
        }
        if (file_exists(DB_PATH)){
            unlink(DB_PATH);
        }
    }
}
