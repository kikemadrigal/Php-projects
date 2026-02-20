<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//El modelo lo hemos atucargado en application/config/autoload.php y no es necesario iniciarlo
		//$this->load->model('Clientes_model');
	}

	public function index()
	{
		//$query=$this->db->query("SELECT * FROM clientes");
		$data['clientes']=$this->Clientes_model->select();
		
		$this->load->view('templates/document_start');
		$this->load->view('clientes/index',$data);
		$this->load->view('templates/document_end');
	}





	//Esta función devolverá un cliente en concreto
	public function find($id){
		if(empty($id)){
			echo "No hay id";
		}else{
			/*
			$sql = "SELECT * FROM clientes WHERE id = ?";
			$query=$this->db->query($sql, $id);
			$data['cliente']=$query->row();
			*/
			$data['cliente']=$this->Clientes_model->selectId($id);
			$this->load->view('templates/document_start');
			$this->load->view('clientes/update',$data);
			$this->load->view('templates/document_end');
		}
		
	}



	//Esta función buscará un@
	public function search(){
			//Compruebo si se ha enviado el submit
			if($this->input->post()){
				$nombre=$this->input->post("nombre");
				/*
				$query=$this->db->query("SELECT * FROM clientes WHERE nombre LIKE '%$nombre%';");
				$data['clientes']=$query->result();
				*/
				$data['clientes']=$this->Clientes_model->selectLike($nombre);
				$this->load->view('templates/document_start');
				$this->load->view('clientes/search',$data);
				$this->load->view('templates/document_end');
				
				echo var_dump($query);
			}else{
				echo "Submit no enviado";
			}
		
	}








	public function form_insert(){
		$this->load->view('templates/document_start');
		$this->load->view('clientes/form_insert');
		$this->load->view('templates/document_end');
	}
	//Esta función añadirá un@ nuev@
	//Este método lo he visto como saveCliente
	public function insert(){
		//Compruebo si se ha enviado por post
		if($this->input->post()){
			//Caputuramos los datos
			$cif=$this->input->post("cif");
			$nombre=$this->input->post("nombre");
			$datos=$this->input->post("datos");
			//campos: id, cif, nombre, datos
			//$fueInsertado=$this->db->query("INSERT INTO clientes VALUES(NULL,'$cif','$nombre','$datos');");
			$fueInsertado=$this->Clientes_model->insert($cif, $nombre, $datos);
      		if($fueInsertado==true){
			  //Si se inserta correctamente redirecciono la pagina a la url por defecto
			  //También es posile redireccionar con header("Location:".base_url());
			  redirect(base_url());
      }else{
          echo "Hubo un problema y no pudo insertarse";
      }
		}else{
			echo "No enviado por post";
		}
	}












	//Esta función actualizará un@
	public function update(){
		$id=$this->input->post("id");
		if(!empty($id)){
			if($this->input->post()){
				$id=$this->input->post("id");
				$cif=$this->input->post("cif");
				$nombre=$this->input->post("nombre");
				$datos=$this->input->post("datos");
				//campos: id, cif, nombre, datos
				//$fueActualizado=$this->db->query("UPDATE clientes SET cif='$cif', nombre='$nombre', datos='$datos' WHERE id=$id;");
				$fueActualizado=$this->Clientes_model->update($id, $cif, $nombre, $datos);
				if($fueActualizado==true){
					//Redireccionamos si fue actualizado
					//También es posile redireccionar con header("Location:".base_url());
					redirect(base_url());
				}else{
					echo "No actualizado";
				}
			}else{
				echo "Submit no enviado";
			}
		}else{
			echo "No envia por post";
		}
	}










	//Esta función eliminará un@
	public function delete($id){
		if(!empty($id)){
			//$fueBorrado=$this->db->query("DELETE FROM clientes WHERE id=$id");
			$fueBorrado=$this->Clientes_model->delete($id);
			if($fueBorrado==true){
				//También es posile redireccionar con header("Location:".base_url());
				redirect(base_url());
			}else{
				echo "No se pudo eliminar";
			}
		}
	}








}
