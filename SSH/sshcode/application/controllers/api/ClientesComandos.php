<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientesComandos extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		/*
		$query=$this->db->query("SELECT * FROM clientesComandos");
		$data['clientesComandos']=$query->result();

		$this->load->view('templates/document_start');
		$this->load->view('clientesComandos/index',$data);
		$this->load->view('templates/document_end');
		*/
	}

    //Esta función devolverá todos los clientesComandos de un cliente
    public function findOneClient($idCliente){
        if(!empty($idCliente)){
			//1 Le pasaremos a la vista el cliente
			/*$sql = "SELECT * FROM clientes WHERE id= ?";
			$query=$this->db->query($sql, $idCliente);
			$data['cliente']=$query->row();*/
			
			//2:le pasamos todos los comandos por si quiere añadir alguno nuevo,los meteremos en un select de html
			/*$query2=$this->db->query("SELECT * FROM comandos");
			$data['comandos']=$query2->result();*/

			//3. Le pasamos todos los comandos asignados a ese cliente
			$sql3 = "Select cc.id, cc.idCliente, cc.idComando, co.nombre from clientesComandos cc INNER JOIN comandos co ON cc.idComando=co.id where cc.idCliente= ?";
			$query3=$this->db->query($sql3, $idCliente);
			$clientesComandos=$query3->result();	

			echo json_encode($clientesComandos);
		}else{
			echo json_encode(null);
		}
		
    }



	//Esta función devolverá un@ en concreto
	public function find($id){
		if(empty($id)){
			$data['resultado']="Sin resultados";
		}else{
			$sql = "SELECT * FROM clientesComandos WHERE id = ?";
			$query=$this->db->query($sql, $id);
			$data['clientesComando']=$query->row();	
		}
		$this->load->view('templates/document_start');
		$this->load->view('clientesComandos/update',$data);
		$this->load->view('templates/document_end');
	}



	//Esta función buscará un@
	public function search(){
			//Compruebo si se ha enviado el submit
			if($this->input->post("submit")){
				$nombre=$this->input->post("nombre");
				$query=$this->db->query("SELECT * FROM clientesComandos WHERE nombre LIKE '%$nombre%';");
				$data['clientesComandos']=$query->result();
				/*
				$this->load->view('templates/document_start');
				$this->load->view('clientesComandos/search',$data);
				$this->load->view('templates/document_end');
				*/
				echo var_dump($query);
			}else{
				echo "Submit no enviado";
			}
		
	}









	//Esta función añadirá un@ nuev@
	public function insert(){
		//Compruebo si se ha enviado el submit
		if($this->input->post("idCliente")){
			$idCliente=$this->input->post("idCliente");
			$idComando=$this->input->post("idComando");
			//campos: id, idCliente, idComando
			$fueInsertado=$this->db->query("INSERT INTO clientesComandos VALUES(NULL,'$idCliente','$idComando');");
			if($fueInsertado==true){
				echo json_encode("El cliente comando fue unsertadi");
			}else{
				echo json_encode("El cliente comando no fue unsertadi");
			}
		}else{
			echo json_encode("No se recibio el idCliente");
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
				$fueActualizado=$this->db->query("UPDATE clientesComandos SET nombre='$nombre', datos='$datos' WHERE id=$id;");
				if($fueActualizado==true){
					echo json_encode("El cliente comando fue actualizado");
				}else{
					echo json_encode("El cliente comando no fue actualizado");
				}
			}else{
				echo json_encode("No se obtuvo el post id");
			}
		}else{
			echo json_encode("El id del comando cliente está vacio");
		}
	}










	//Esta función eliminará un@
	public function delete($id){
		//echo json_encode("Has pasado el id para borrar ".$id);
		
		if(!empty($id)){
			$fueBorrado=$this->db->query("DELETE FROM clientesComandos WHERE id=$id");
			if($fueBorrado==true){
				echo json_encode("El comando cliente fue borrado");
			}else{
				echo json_encode("El comando cliente no fue borrado");
			}
		}
	}








}