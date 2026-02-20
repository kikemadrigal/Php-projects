<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claves extends CI_Controller {

	public function __construct(){
		parent::__construct();
    }
    public function mostrarClave(){
        $nombre_archivo = "public/files/authorized_keys";  //variable con el nombre del archivo que vamos a crear
 
        /* 1.- Si el archivo existe mostramos en el navegador el contenido con
         * "file_get_contents" que nos devuelve lo que hay en el archivo
         * logs.txt.
         * 2.-forzamos con nl2br que los saltos de linea "\n" los muestre en HTML <br />
        */
        if(file_exists($nombre_archivo)) 
        {
            $data['contenido']=  nl2br(file_get_contents($nombre_archivo));
        }
        else
        {
            $data['contenido']="El archivo no existe";
        }
        $this->load->view('templates/document_start');
		$this->load->view('claves/index',$data);
		$this->load->view('templates/document_end');
    }
}