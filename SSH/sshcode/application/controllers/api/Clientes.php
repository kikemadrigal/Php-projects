<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//El código 404 es que no se ha encontrado
//Le pasamos el código 200 en el array para decirle que la respuesta es satisfactoria
//El 400 es que no se ha psaado el id
class Clientes extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	//Delvolverá tod@s
	public function index()
	{
		$query=$this->db->query("SELECT * FROM clientes");
		$clientes=$query->result();
		if(!is_null($clientes)){
			//echo var_dump($query);
			echo json_encode($clientes);
		}else{
			echo json_encode(null);
		}	
	}





	//Esta función devolverá un cliente en concreto
	public function find($id){
		if(empty($id)){
			echo json_encode(null);
		}else{
			$sql = "SELECT * FROM clientes WHERE id = ?";
			$query=$this->db->query($sql, $id);
			$cliente=$query->row();	
			echo json_encode($cliente);
		}
	}



	//Esta función buscará un@
	public function search(){
			//Compruebo si se ha enviado el submit
			if($this->input->post("nombre")){
				$nombre=$this->input->post("nombre");
				$query=$this->db->query("SELECT * FROM clientes WHERE nombre LIKE '%$nombre%';");
				$clientes=$query->result();
				echo json_encode($clientes);
			}else{
				echo json_encode(null);
			}
		
	}







	//Esta función añadirá un@ nuev@
	public function insert(){
		//Compruebo si se ha enviado el submit
		if($this->input->post("cif")){
			$cif=$this->input->post("cif");
			$nombre=$this->input->post("nombre");
			$datos=$this->input->post("datos");
			//campos: id, cif, nombre, datos
			$fueInsertado=$this->db->query("INSERT INTO clientes VALUES(NULL,'$cif','$nombre','$datos');");
			if($fueInsertado==true){
					echo json_encode("Cliente insertado");
			}else{
					echo json_encode("Cliente no insertado");
			}
		}else{
			echo json_encode("Cif no enviado");
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
				$fueActualizado=$this->db->query("UPDATE clientes SET cif='$cif', nombre='$nombre', datos='$datos' WHERE id=$id;");
				if($fueActualizado==true){
					echo json_encode("Cliente actualizado");
				}else{
					echo json_encode("Cliente no actualizado");
				}
			}else{
				echo json_encode("id post no enviado");
			}
		}else{
			echo json_encode("No existe un id de cliente para actualizar");
		}
	}










	//Esta función eliminará un@
	public function delete($id){
		//echo json_encode("El json pasado es el ".$id);
		
		if(!empty($id)){
			$fueBorrado=$this->db->query("DELETE FROM clientes WHERE id=$id");
			if($fueBorrado==true){
				echo json_encode("Cliente borrado");
			}else{
				echo json_encode("Cliente no borrado");
			}
		}
		
	}








}
