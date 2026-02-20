<?php
Class Multimedia {
	private $id;
	private $name;
    private $path;
    private $type;
    private $user;
	private $game;

	function __construct($id){
		$this->id=$id;
	}

	function setName($name){
		$this->name=$name;
	}
	function setType($type){
		$this->type=$type;
	}
    function setPath($path){
		$this->path=$path;
	}
    function setUser($user){
		$this->user=$user;
	}
    function setgame($game){
		$this->game=$game;
	}
	

	
	function getId(){
		return $this->id;	
	}
	function getName(){
		return $this->name;
	}
    function getType(){
		return $this->type;
	}
    function getPath(){
		return $this->path;
	}
    function getUser(){
		return $this->user;
	}
    function getGame(){
		return $this->game;
	}


	
	function toString(){
		return "Multimedia: Id: ".$this->id.", name: ".$this->name;	
	}
}