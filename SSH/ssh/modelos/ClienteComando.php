<?php
class ClienteComando{
    private $id;
	private $idCliente;
    private $idComando;
    function __construct($id, $idCliente, $idComando){
		$this->id=$id;
        $this->idCliente=$idCliente;
        $this->idComando=$idComando;
    }
    		
	function getId(){
		return $this->id;
    }
    		
	function getIdCliente(){
		return $this->idCliente;
    }
    		
	function getIdComando(){
		return $this->idComando;
	}
    function toString(){
		return "Cliente-comando: id: ".$this->id.", idCliente: ".$this->idCliente.", idComando: ".$this->idComando;	
	}
}

?>