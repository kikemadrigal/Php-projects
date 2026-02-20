<?php
class Comando{
  private $id;
  private $nombre;
  private $datos;
  function __construct($id, $nombre, $datos){
  $this->id=$id;
      $this->nombre=$nombre;
      $this->datos=$datos;
  }
  function getId(){
		return $this->id;
	}
  function getNombre(){
    return $this->nombre;
  }
  function getDatos(){
    return $this->datos;
  }
  function toString(){
    return "Comando: id: ".$this->id.", cif: ".$this->cif.", nombre: ".$this->nombre.", datos: ".$this->datos;	
	}
}
?>