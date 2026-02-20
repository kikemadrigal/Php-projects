<?php 
class Archivo{
	private $archivo;
	private $idUsuario;
	private $rutaAlmacenamiento;
	private $nombreArchivo;
	private $fecha;
	function __construct($archivo,$nombreArchivo,$idUsuario,$fecha){
		$this->archivo=$archivo;
		$this->nombreArchivo=$nombreArchivo;
		$this->idUsuario=$idUsuario;
		$this->rutaAlmacenamiento="resources/imagesusers";
		$this->fecha=$fecha;
	}
	//Esta función añade las carpetas idUsuario y fotos a ../../resources/assets/imagesusers
	private function generarDirectoriosParaGuardarArchivos(){
		$carpetafoto="fotos";
		$ruta="";
			if (!file_exists($this->rutaAlmacenamiento)) {
				mkdir($this->rutaAlmacenamiento, 0777, true);
				$ruta=$this->rutaAlmacenamiento ;
			}else{
				$ruta=$this->rutaAlmacenamiento;
			}
			if (!file_exists($ruta."/".$this->idUsuario)) {
				mkdir($ruta."/".$this->idUsuario, 0777, true);
				$ruta .="/".$this->idUsuario;
			}else{
				$ruta .="/".$this->idUsuario;
			}
			/*if (!file_exists($ruta."/".$carpetafoto)) {
				mkdir($ruta."/".$carpetafoto, 0777, true);
				$ruta.="/".$carpetafoto;
			}else{
				$ruta .="/".$carpetafoto;
			}*/
		return $ruta;
	}
	public function subirArchivo(){
		$fotosubida=false;
		$fotosubida=move_uploaded_file( $this->archivo, $this->generarDirectoriosParaGuardarArchivos()."/".$this->fecha."-".$this->nombreArchivo );
		return $fotosubida;
	}
	
	
}

?>