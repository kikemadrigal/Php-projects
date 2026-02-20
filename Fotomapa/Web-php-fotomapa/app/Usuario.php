<?php
class Usuario {
	private $id;
	private $nombre;
	private $clave;
	private $tipo;
	private $correo;
	private $nombreReal;
	private $apellidos;
	private $web;
	private $validado;
	private $contador;
	private $fecha;
	private $datos;
	
	function __construct($id,$nombre,$clave,$tipo,$correo,$nombreReal,$apellidos,$web,$validado,$contador){
		$this->id=$id;
		$this->nombre=$nombre;
		$this->clave=$clave;
		$this->tipo=$tipo;
		$this->correo=$correo;
		$this->nombreReal=$nombreReal;
		$this->apellidos=$apellidos;
		$this->web=$web;
		$this->validado=$validado;
		$this->contador=$contador;
		$this->fecha="Sin fecha";
		$this->datos="Sin datos";
	}
	
	function setNombre($nombre){
		$this->nombre=$nombre;
	}
	function setClave($clave){
		$this->clave=$clave;
	}
	
	function setTipo($tipo){
		$this->nivelAcceso=$nivelAcceso;	
	}
	
	function setCorreo($correo){
		$this->correo=$correo;
	}
	
	function setNombreReal($nombreReal){
		$this->nombreReal=$nombreReal;
	}
	
	function setApellidos($apellidos){
		$this->apellidos=$apellidos;
	}
	function setWeb($web){
		$this->web=$web;
	}
	function setValidado($validado){
		$this->validado=$validado;
	}
	function setContador($contador){
		$this->contador=$contador;
	}
	function setFecha($fecha){
		$this->fecha=$fecha;
	}
	function setDatos($datos){
		$this->datos=$datos;
	}
	
	function getId(){
		return $this->id;	
	}
	function getNombre(){
		return $this->nombre;
	}
	function getClave(){
		return $this->clave;
	}
	function getTipo(){
		return $this->tipo;
	}
	function getCorreo(){
		return $this->correo;
	}
	function getNombreReal(){
		return $this->nombreReal;
	}
	function getApellidos(){
		return $this->apellidos;
	}
	function getWeb(){
		return $this->web;
	}
	function getValidado(){
		return $this->validado;
	}
	function getContador(){
		return $this->contador;
	}
	function getFecha(){
		$this->fecha;
	}
	function getDatos(){
		$this->datos;
	}
	
	
	
	function toString(){
		return "Id : ".$this->id.", nombre: ".$this->nombre.", clave: ".$this->clave.", tipo: ".$this->tipo.", correo: ".$this->correo.", nombre real: ".$this->nombreReal.", apellidos: ".$this->apellidos.", web: ".$this->web.", validado: ".$this->validado.", contador: ".$this->contador.", fecha. ".$this->fecha.", datos: ".$this->datos;	
	}
	
	
}

?>