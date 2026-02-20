<?php

Class ComentarioWeb {
	private $idComentarioWeb;
	private $nombreComentarioWeb;
	private $textoComentarioWeb;
	private $fechaComentarioWeb;
	private $validadoComentarioWeb;
	private $idWebComentarioWeb;
	
	
	function __construct($idComentarioWeb){
		$this->idComentarioWeb=$idComentarioWeb;
	}
	
	function setNombreComentarioWeb($nombreComentarioWeb){
		$this->nombreComentarioWeb=$nombreComentarioWeb;
	}
	function setTextoComentarioWeb($textoComentarioWeb){
		$this->textoComentarioWeb=$textoComentarioWeb;
	}
	
	function setFechaComentarioWeb($fechaComentarioWeb){
		$this->fechaComentarioWeb=$fechaComentarioWeb;	
	}
	function setValidadoComentarioWeb($validadoComentarioWeb){
		$this->validadoComentarioWeb=$validadoComentarioWeb;	
	}
	
	function setIdWebComentarioWeb($idWebComentarioWeb){
		$this->idWebComentarioWeb=$idWebComentarioWeb;
	}
	

	
	function getIdComentarioWeb(){
		return $this->idComentarioWeb;	
	}
	function getNombreComentarioWeb(){
		return $this->nombreComentarioWeb;
	}
	function getTextoComentarioWeb(){
		return $this->textoComentarioWeb;
	}
	function getFechaComentarioWeb(){
		return $this->fechaComentarioWeb;
	}
	function getValidadoComentarioWeb(){
		return $this->validadoComentarioWeb;
	}
	function getIdWebComentarioWeb(){
		return $this->idWebComentarioWeb;
	}
	
	
	
	
	function toString(){
		return "Comentario: ".$this->nombreComentarioWeb.", id: ".$this->idComentario;	
	}
	
	
}

?>