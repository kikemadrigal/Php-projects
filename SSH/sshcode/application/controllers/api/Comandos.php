<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comandos extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$query=$this->db->query("SELECT * FROM comandos");
		$comandos=$query->result();
		if(!is_null($comandos)){
			echo json_encode($comandos);
		}else{
			echo json_encode(null);
		}
	}





	//Esta función devolverá un@ en concreto
	public function find($id){
		if(empty($id)){
			echo json_encode(null);
		}else{
			$sql = "SELECT * FROM comandos WHERE id = ?";
			$query=$this->db->query($sql, $id);
			$comando=$query->row();	
			echo json_encode($comando);
		}
	
	}



	//Esta función buscará un@
	public function search(){
			//Compruebo si se ha enviado el submit
			if($this->input->post("submit")){
				$nombre=$this->input->post("nombre");
				$query=$this->db->query("SELECT * FROM comandos WHERE nombre LIKE '%$nombre%';");
				$comandos=$query->result();
				echo json_encode($comandos);
			}else{
				echo json_encode(null);
			}
		
	}







	//Esta función añadirá un@ nuev@
	public function insert(){
		//Compruebo si se ha enviado el submit
		if($this->input->post("nombre")){
			$nombre=$this->input->post("nombre");
			$datos=$this->input->post("datos");
			//campos: id, cif, nombre, datos
			$fueInsertado=$this->db->query("INSERT INTO comandos VALUES(NULL,'$nombre','$datos');");
			if($fueInsertado==true){
					echo json_encode("Comando insertado");
			}else{
				echo json_encode("Comando no insertado");
			}
		}else{
			echo json_encode("Nombre no enviado");
		}
	}












	//Esta función actualizará un@
	public function update(){
		$id=$this->input->post("id");
		if(!empty($id)){
			if($this->input->post("id")){
				$id=$this->input->post("id");
				$cif=$this->input->post("cif");
				$nombre=$this->input->post("nombre");
				$datos=$this->input->post("datos");
				//campos: id, cif, nombre, datos
				$fueActualizado=$this->db->query("UPDATE comandos SET nombre='$nombre', datos='$datos' WHERE id=$id;");
				if($fueActualizado==true){
					echo json_encode("Comando actualizado");
				}else{
					echo json_encode("Comando no actualizado");
				}
			}else{
				echo json_encode("id post del Comando enviado");
			}
		}else{
			echo json_encode("El id del coando esta vacio");
		}
	}










	//Esta función eliminará un@
	public function delete($id){
		if(!empty($id)){
			$fueBorrado=$this->db->query("DELETE FROM comandos WHERE id=$id");
			if($fueBorrado==true){
				echo json_encode("Comando borrado");
			}else{
				echo json_encode("Comando borrado");
			}
		}
	}








}