<?php

Class Usuario {
	private $idUsuario;
	private $nombreUsuario;
	private $claveUsuario;
	private $nivelAccesoUsuario;
	private $correoUsuario;
	private $nombreRealUsuario;
	private $apellidosUsuario;
	private $webUsuario;
	private $validadoUsuario;
	
	function __construct($idUsuario){
		$this->idUsuario=$idUsuario;
	}
	
	function setNombreUsuario($nombreUsuario){
		$this->nombreUsuario=$nombreUsuario;
	}
	function setClaveUsuario($claveUsuario){
		$this->claveUsuario=$claveUsuario;
	}
	
	function setNivelAccesoUsuario($nivelAccesoUsuario){
		$this->nivelAccesoUsuario=$nivelAccesoUsuario;	
	}
	
	function setCorreoUsuario($correoUsuario){
		$this->correoUsuario=$correoUsuario;
	}
	
	function setNombreRealUsuario($nombreRealUsuario){
		$this->nombreRealUsuario=$nombreRealUsuario;
	}
	
	function setApellidosUsuario($apellidosUsuario){
		$this->apellidosUsuario=$apellidosUsuario;
	}
	function setWebUsuario($webUsuario){
		$this->webUsuario=$webUsuario;
	}
	function setValidadoUsuario($validadoUsuario){
		$this->validadoUsuario=$validadoUsuario;
	}
	
	
	function getIdUsuario(){
		return $this->idUsuario;	
	}
	function getNombreUsuario(){
		return $this->nombreUsuario;
	}
	function getClaveUsuario(){
		return $this->claveUsuario;
	}
	function getNivelAccesoUsuario(){
		return $this->nivelAccesoUsuario;
	}
	function getCorreoUsuario(){
		return $this->correoUsuario;
	}
	function getNombreRealUsuario(){
		return $this->nombreRealUsuario;
	}
	function getApellidosUsuario(){
		return $this->apellidosUsuario;
	}
	function getWebUsuario(){
		return $this->webUsuario;
	}
	function getValidadoUsuario(){
		return $this->validadoUsuario;
	}
	
	
	
	
	function toString(){
		return "Usuario: ".$this->nombreUsuario.", id: ".$this->idUsuario;	
	}
	
	
}

?>