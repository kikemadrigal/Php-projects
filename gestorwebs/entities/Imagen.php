<?php

Class Imagen {
	private $idImagen;
	private $nombreImagen;
	private $idWeb;

	function __construct($idImagen){
		$this->idImagen=$idImagen;
	}
	
	function setNombreImagen($nombreImagen){
		$this->nombreImagen=$nombreImagen;
	}
	function setIdWeb($idWeb){
		$this->idWeb=$idWebb;
	}
	
	

	
	function getIdImagen(){
		return $this->idImagen;	
	}
	function getNombreImagen(){
		return $this->nombreImagen;
	}
	function getIdWeb(){
		return $this->idWeb;
	}
	
	
	
	
	function toString(){
		return "Imagen: ".$this->nombreImagen.", id: ".$this->idImagen;	
	}
	
	
}

?>