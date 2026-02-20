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
			$sql = "SELECT * FROM clientes WHERE id= ?";
			$query=$this->db->query($sql, $idCliente);
			$data['cliente']=$query->row();
			
			//2:le pasamos todos los comandos por si quiere añadir alguno nuevo,los meteremos en un select de html
			$query2=$this->db->query("SELECT * FROM comandos");
			$data['comandos']=$query2->result();

			//3. Le pasamos todos los comandos asignados a ese cliente
			$sql3 = "Select cc.id, cc.idCliente, cc.idComando, co.nombre from clientesComandos cc INNER JOIN comandos co ON cc.idComando=co.id where cc.idCliente= ?";
			$query3=$this->db->query($sql3, $idCliente);
			$data['clientesComandos']=$query3->result();	

			$this->load->view('templates/document_start');
			$this->load->view('clientesComandos/findOneClient',$data);
			$this->load->view('templates/document_end');
		}else{
			echo "No exista el idCliente";
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
		if($this->input->post("submit")){
			$idCliente=$this->input->post("idCliente");
			$idComando=$this->input->post("idComando");
			//campos: id, idCliente, idComando
			$fueInsertado=$this->db->query("INSERT INTO clientesComandos VALUES(NULL,'$idCliente','$idComando');");
      if($fueInsertado==true){
			  //Si se inserta correctamente redirecciono la pagina a la url por defecto
		
			  redirect(base_url()."clientesComandos/findOneClient/".$idCliente);
			  //redirect(base_url());

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
				$fueActualizado=$this->db->query("UPDATE clientesComandos SET nombre='$nombre', datos='$datos' WHERE id=$id;");
				if($fueActualizado==true){
					//Redireccionamos si fue actualizado
					redirect(base_url()."clientesComandos/index");
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
	public function delete($id, $idCliente){
		echo "vamos a borrar el clienteComando: ".$id.", del cliente".$idCliente;
		if(!empty($id)){
			$fueBorrado=$this->db->query("DELETE FROM clientesComandos WHERE id=$id");
			if($fueBorrado==true){
				redirect(base_url()."clientesComandos/findOneClient/".$idCliente);
			}else{
				echo "No se pudo eliminar";
			}
		}
	}








}