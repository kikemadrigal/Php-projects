<?php

Class Categoria {
	private $idCategoria;
	private $nombreCategoria;
	
	private $titulocategoria;
	private $categoriaEsHijaDe;
	private $idPadreCategoria;
	private $nivelCategoria;
	private $redireccionCategoria;

	
	function __construct($idCategoria){
		$this->idCategoria=$idCategoria;
	}
	
	function setNombreCategoria($nombreCategoria){
		$this->nombreCategoria=$nombreCategoria;
	}
	function setTituloCategoria($titulocategoria){
		$this->titulocategoria=$titulocategoria;
	}
	function setCategoriaEsHijaDe($categoriaEsHijaDe){
		$this->categoriaEsHijaDe=$categoriaEsHijaDe;
	}	
	function setIdPadreCategoria($idPadreCategoria){
		$this->idPadreCategoria=$idPadreCategoria;	
	}
	
	function setNivelCategoria($nivelCategoria){
		$this->nivelCategoria=$nivelCategoria;
	}
	function setRedireccionCategoria($redireccionCategoria){
		$this->redireccionCategoria=$redireccionCategoria;
	}

	
	function getIdCategoria(){
		return $this->idCategoria;	
	}
	function getNombreCategoria(){
		return $this->nombreCategoria;
	}
	function getTituloCategoria(){
		return $this->titulocategoria;
	}
	function getCategoriaEsHijaDe(){
		return $this->categoriaEsHijaDe;
	}
	function getIdPadreCategoria(){
		return $this->idPadreCategoria;
	}
	function getNivelCategoria(){
		return $this->nivelCategoria;
	}
	function getRedireccionCategoria(){
		return $this->redireccionCategoria;
	}
	
	
	
	function toString(){
		return "Categoria: ".$this->nombreCategoria.", id: ".$this->idCategoria;	
	}
	
	 
}

?>