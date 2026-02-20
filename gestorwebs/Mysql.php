<?php
class Mysql{

	private $servidor;
	private $usuario;
	private $password;
	private $base_de_datos;
	private $resultado;
	public $enlace;

	public function __construct(){

		$this->servidor=SERVER;
		$this->usuario=USER;
		$this->password=PASSWORD;
		$this->base_de_datos=DATABASE;
		//$this->conectar_mysql();
	}
	/* Realliza la conexión a la base de datos */
	public function conectar_mysql(){
        	$this->enlace = new mysqli($this->servidor, $this->usuario, $this->password,$this->base_de_datos);
        	$this->enlace->query("SET NAMES 'utf8'");
			if($this->enlace->connect_errno){
				echo "<p>Error al conectar con el servidor.</p>";
				//die (“ERROR AL CONECTAR MYSQL”);
			}

	}

	/*metodo para ejecutar una secuencia sql*/
	public function ejecutar_sql($sql){
		//envía una única consulta a la base de datos actualmente activa en el servidor 
		$this->resultado=$this->enlace->query($sql);
		if (!$this->resultado) {
			echo "<p>Error al ejecutar la consulta</p>";
		}
		return $this->resultado;
	}
	//Desconectar y liberar
	public function desconectar(){
		//$this->resultado->free();
		$this->enlace->close();
		
	}
	
		
	
	


}

?>