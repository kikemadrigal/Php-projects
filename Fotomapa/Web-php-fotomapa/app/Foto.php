<?php
class Foto {
	private $id;
	private $name;
	private $text;
	private $type;
	private $address;
	private $city;
	private $country;
	private $lat;
	private $lng;
	private $user;
	private $validada;
	private $timeStamp;
	/*function __construct($id, $name){
		$this->id=$id;
		$this->name=$name;
	}*/

	function __construct($id, $name, $text, $type, $address, $city, $country, $lat, $lng, $user,$validada, $timestamp){
		$this->id=$id;
		$this->name=$name;
		$this->text=$text;
		$this->type=$type;
		$this->address=$address;
		$this->city=$city;
		$this->country=$country;
		$this->lat=$lat;
		$this->lng=$lng;
		$this->user=$user;
		$this->validada=$validada;
		$this->timeStamp=$timestamp;
	}

		
	function getId(){
		return $this->id;
	}
	function getName(){
		return $this->name;
	}
	function getText(){
		return $this->text;
	}
	//El type es para decir si es un restaurante, bar, etc
	function getType(){
		return $this->type;
	}
	function getAddress(){
		return $this->address;
	}
	function getCity(){
		return $this->city;
	}
	function getCountry(){
		return $this->country;
	}
	function getLat(){
		return $this->lat;
	}
	function getLng(){
		return $this->lng;
	}
	function getUser(){
		return $this->user;
	}
	function getValidada(){
		return $this->validada;
	}
	function getTimeStamp(){
		return $this->timeStamp;
	}

	function toString(){
		return "Foto: ".$this->name.", id: ".$this->id;	
	}
	
	
}

?>