<?php

Class Web {
	private $idWeb;
	private $nombreWeb;
	private $tituloWeb;
	private $descricionWeb;
	private $fechaWeb;
	private $tagsWeb;
	private $numeroVotosWeb;
	private $mediaVotosWeb;
	private $imagenWeb;
	private $categoriaWeb;
	private $contadorWeb;
	function __construct($idWeb){
		$this->idWeb=$idWeb;
	}
	
	function setNombreWeb($nombreWeb){
		$this->nombreWeb=$nombreWeb;
	}
	function setTituloWeb($tituloWeb){
		$this->tituloWeb=$tituloWeb;
	}
	function setDescripcionWeb($descricionWeb){
		$this->descricionWeb=$descricionWeb;
	}
	
	function setFechaWeb($fechaWeb){
		$this->fechaWeb=$fechaWeb;	
	}
	
	function setTagsWeb($tagsWeb){
		$this->tagsWeb=$tagsWeb;
	}
	function setNumeroVotosWeb($numeroVotosWeb){
		$this->numeroVotosWeb=$numeroVotosWeb;
	}
	function setMediaVotosWeb($mediaVotosWeb){
		$this->mediaVotosWeb=$mediaVotosWeb;
	}
	function setImagenWeb($imagenWeb){
		$this->imagenWeb=$imagenWeb;
	}
	function setCategoriaWeb($categoriaWeb){
		$this->categoriaWeb=$categoriaWeb;
	}
	function setContadorWeb($contadorWeb){
		$this->contadorWeb=$contadorWeb;
	}
	
	function getIdWeb(){
		return $this->idWeb;	
	}
	function getNombreWeb(){
		return $this->nombreWeb;
	}
	function getTituloWeb(){
		return $this->tituloWeb;
	}
	function getDescripcionWeb(){
		return $this->descricionWeb;
	}
	function getFechaWeb(){
		return $this->fechaWeb;
	}
	function getTagsWeb(){
		return $this->tagsWeb;
	}
	function getNumeroVotosWeb(){
		return $this->numeroVotosWeb;
	}
	function getMediaVotosWeb(){
		return $this->mediaVotosWeb;
	}
	function getImagenWeb(){
		return $this->imagenWeb;
	}
	function getCategoriaWeb(){
		return $this->categoriaWeb;
	}
	function getContadorWeb(){
		return $this->contadorWeb;
	}
	
	
	function toString(){
		return "Web: ".$this->nombreWeb.", id: ".$this->idWeb;	
	}
	
	
}

?>