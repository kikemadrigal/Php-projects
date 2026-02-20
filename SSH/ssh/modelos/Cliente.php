<?php
class Cliente{
  private $id;
  private $cif;
  private $nombre;
  private $datos;
  function __construct($id, $cif, $nombre, $datos){
    $this->id=$id;
    $this->cif=$cif;
    $this->nombre=$nombre;
    $this->datos=$datos;
  }
  function getId(){
    return $this->id;
	}
	function getCif(){
    return $this->cif;
  }
  function getNombre(){
    return $this->nombre;
  }
  function getDatos(){
    return $this->datos;
  }
  function toString(){
    return "Cliente: id: ".$this->id.", cif: ".$this->cif.", nombre: ".$this->nombre.", datos: ".$this->datos;	
	}

}
?>