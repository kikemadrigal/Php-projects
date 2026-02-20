<?php 
class Claves extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}


	public function guardarClave(){
		if($this->input->post("archivo")){
			$clavePublica=$this->input->post("archivo");
		
			$nombre_archivo ="public/files/authorized_keys"; 
			if(!file_exists($nombre_archivo)){
				$mensaje = "El Archivo $nombre_archivo no existe";
			//Si existe el archivo 
			}else{
				//33060 -r--r--r-- 
				//33188 -rw-r--r-- 
				//33206 -rw-rw-rw-
				$permisos = fileperms($nombre_archivo);
				$tieneLosPermisos=false;
				if($permisos ==33206){
					$tieneLosPermisos=true;
				}else{
					$tieneLosPermisos=false;
				}
				//Si no tiene los permisos
				if(!$tieneLosPermisos){
					//Mandamos el mensaje con faltan
					$mensaje="faltan";
				//Si tiene los permisos	
				}else{
					//$mensaje="Tiene todos los permisos";
					if($archivo = fopen($nombre_archivo, "w"))
					{
						if(fwrite($archivo,$clavePublica))
						{
							$mensaje ="Se ha creado el archivo $nombre_archivo y se ha introducido el texto $clavePublica";
						}
						else
						{
							$mensaje= "Ha habido un problema al crear el archivo";
						}
						fclose($archivo);
					}
				}
			
			}
			echo json_encode($mensaje);
		}else{
			echo json_encode("No encontrado el archivo");
		}
	}




}


?>