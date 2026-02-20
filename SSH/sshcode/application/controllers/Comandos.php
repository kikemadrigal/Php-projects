<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comandos extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$query=$this->db->query("SELECT * FROM comandos");
		$data['comandos']=$query->result();

		$this->load->view('templates/document_start');
		$this->load->view('comandos/index',$data);
		$this->load->view('templates/document_end');
	}





	//Esta función devolverá un@ en concreto
	public function find($id){
		if(empty($id)){
			$data['resultado']="Sin resultados";
		}else{
			$sql = "SELECT * FROM comandos WHERE id = ?";
			$query=$this->db->query($sql, $id);
			$data['comando']=$query->row();	
		}
		$this->load->view('templates/document_start');
		$this->load->view('comandos/update',$data);
		$this->load->view('templates/document_end');
	}



	//Esta función buscará un@
	public function search(){
			//Compruebo si se ha enviado el submit
			if($this->input->post("submit")){
				$nombre=$this->input->post("nombre");
				$query=$this->db->query("SELECT * FROM comandos WHERE nombre LIKE '%$nombre%';");
				$data['comandos']=$query->result();
				/*
				$this->load->view('templates/document_start');
				$this->load->view('comandos/search',$data);
				$this->load->view('templates/document_end');
				*/
				echo var_dump($query);
			}else{
				echo "Submit no enviado";
			}
		
	}








	public function form_insert(){
		$this->load->view('templates/document_start');
		$this->load->view('comandos/form_insert');
		$this->load->view('templates/document_end');
	}
	//Esta función añadirá un@ nuev@
	public function insert(){
		//Compruebo si se ha enviado el submit
		if($this->input->post("submit")){
			$cif=$this->input->post("cif");
			$nombre=$this->input->post("nombre");
			$datos=$this->input->post("datos");
			//campos: id, cif, nombre, datos
			$fueInsertado=$this->db->query("INSERT INTO comandos VALUES(NULL,'$nombre','$datos');");
      if($fueInsertado==true){
			  //Si se inserta correctamente redirecciono la pagina a la url por defecto
			  redirect(base_url()."comandos/index");
      }else{
          echo "Hubo un problema y no pudo insertarse";
      }
		}else{
			echo "Submit no enviado";
		}
	}












	//Esta función actualizará un@
	public function update(){
		$id=$this->input->post("id");
		if(!empty($id)){
			if($this->input->post("submit")){
				$id=$this->input->post("id");
				$cif=$this->input->post("cif");
				$nombre=$this->input->post("nombre");
				$datos=$this->input->post("datos");
				//campos: id, cif, nombre, datos
				$fueActualizado=$this->db->query("UPDATE comandos SET nombre='$nombre', datos='$datos' WHERE id=$id;");
				if($fueActualizado==true){
					//Redireccionamos si fue actualizado
					redirect(base_url()."comandos/index");
				}else{
					echo "No actualizado";
				}
			}else{
				echo "Submit no enviado";
			}
		}else{
			echo "No existe una id para actualizar";
		}
	}










	//Esta función eliminará un@
	public function delete($id){
		if(!empty($id)){
			$fueBorrado=$this->db->query("DELETE FROM comandos WHERE id=$id");
			if($fueBorrado==true){
				redirect(base_url());
			}else{
				echo "No se pudo eliminar";
			}
		}
	}








}