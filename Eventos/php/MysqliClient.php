<?php
class MysqliClient{
	private $servidor;
	private $usuario;
	private $password;
	private $base_de_datos;
	private $resultado;
	public $msqli;

	public function __construct(){
		$this->servidor=DB_HOST;
		$this->usuario=DB_USER;
		$this->password=DB_PASS;
		$this->base_de_datos=DB_NAME;


	}
	/* Realliza la conexión a la base de datos */
	public function conectar_mysql(){
        	$this->msqli = new mysqli($this->servidor, $this->usuario, $this->password,$this->base_de_datos);
        	$this->msqli->query("SET NAMES 'utf8'");
			//$this->mysqli_result=new mysqli_result();
			if($this->msqli->connect_errno){
				echo "<p>Error al conectar con el servidor.</p>";
				//die (“ERROR AL CONECTAR MYSQL”);
			}

	}

	public function getMysqliObject(){
		return $this->msqli;
	}

	public function getTables(){
		$tables=array();
		$resultado = $this->msqli->query("SHOW TABLES");
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$tables[]= $linea[0];
		}
		return $tables;
	}
    public function get_evento($nombre){
		$evento=null;
        $consulta  = "SELECT * FROM eventos WHERE nombre='".$nombre."'";
        $resultado=$this->msqli->query($consulta);
        if(is_null($resultado))echo "resultado es null";
        while ($linea = mysqli_fetch_array($resultado)) {
			$evento= $linea;
		}
		return $evento;
    }
    public function get_id_evento($nombre){
		$evento=null;
        $consulta  = "SELECT id FROM eventos WHERE nombre='".$nombre."'";
        $resultado=$this->msqli->query($consulta);
        if(is_null($resultado))echo "resultado es null";
        while ($linea = mysqli_fetch_array($resultado)) {
			$evento = $linea[0];
		}
		return $evento;

    }
    public function get_id_participante($nombre){
        $consulta  = "SELECT id FROM participantes WHERE nombre='".$nombre."'";
        $resultado=$this->msqli->query($consulta);
        if(is_null($resultado))echo "resultado es null";
        return mysqli_fetch_array($resultado);
    }

	public function get_all_eventos(){
		$consulta  = "SELECT * FROM eventos";
		$resultado=$this->msqli->query($consulta);
		if(is_null($resultado))echo "resultado es null";
		return mysqli_fetch_array($resultado);
	}
    public function get_all_participantes(){
		$consulta  = "SELECT * FROM participantes";
		$resultado=$this->msqli->query($consulta);
		if(is_null($resultado))echo "resultado es null";
		return mysqli_fetch_array($resultado);
	}
    public function get_all_participantes_evento($id_evento){
		$participantes=[];
        $consulta  = "SELECT * FROM participantes WHERE id_evento='".$id_evento."'";
        $resultado=$this->msqli->query($consulta);
        if(is_null($resultado))echo "resultado es null";
		while ($linea = mysqli_fetch_array($resultado)) {
			$participante=new Participante($linea['id'], $linea['nombre'], $linea['asistencia'], $linea['pagado'], $linea['comentario'], $linea['id_evento']);
			$participantes[]=$participante;
		}
        return $participantes;
    }


	/*metodo para ejecutar una secuencia sql*/
	public function ejecutar_sql($sql){
		//envía una única consulta a la base de datos actualmente activa en el servidor 
		$this->resultado=$this->msqli->query($sql);
		if (!$this->resultado) {
			echo "<p>Error al ejecutar la consulta</p>";
			$this->resultado=NULL;
		}
		return $this->resultado;
	}

	public function insert_evento($nombre, $fecha, $direccion){
        $sql = "INSERT INTO eventos (id,nombre,fecha,direccion)  VALUES (nombre='".$nombre."',fecha='".$fecha."',direccion='".$direccion."');";
        $this->resultado=$this->msqli->query($sql);
        if (!$this->resultado) {
			echo "<p>Error al ejecutar la consulta</p>";
			$this->resultado=NULL;
		}
		return $this->resultado;
	}
    public function insert_participante($nombre, $asistencia, $pagado, $comentario, $id_evento){
        $sql = "INSERT INTO participantes (nombre,asistencia,pagado, comentario, id_evento)  VALUES nombre='".$nombre."',asistencia='".$asistencia."',pagado='".$pagado."', comentario='".$comentario."', id_evento='".$id_evento."';";
        $this->resultado=$this->msqli->query($sql);
        if (!$this->resultado) {
			echo "<p>Error al ejecutar la consulta</p>";
			$this->resultado=NULL;
		}
		return $this->resultado;
	}

    public function update_evento($id, $nombre, $fecha, $direccion){
		$sql="update cat set nombre='".$nombre."', fecha='".$fecha."', direccion='".$direccion."' WHERE id='".$id."'";
        $this->msqli->query($sql);
    }
    public function update_participante($id, $nombre, $asistencia, $pagado, $comentario, $id_evento){
		$sql="update cat set nombre='".$nombre."', asistencia='".$asistencia."', pagado='".$pagado."', comentario='".$comentario."', id_evento='".$id_evento."' WHERE id='".$id."'";
        $this->msqli->query($sql);
    }
    public function delete_evento($id){
        $sql="DELETE FROM eventos WHERE id='".$id."' LIMIT 1";
        $this->msqli->query($sql);
    }
    public function delete_participante($id){
        $sql="DELETE FROM particioantes WHERE id='".$id."' LIMIT 1";
        $this->msqli->query($sql);
    }

	public function deleteTable($table){
		if($this->msqli->query("DROP TABLE games")){
			echo "<p>tabla borrada</p>";
		}else{
			echo "<p>no se pudo borrar</p>";
		}
	}



		
	
	
	//Desconectar y liberar
	public function desconectar(){
		//$this->resultado->free();
		$this->msqli->close();
	}

}

?>