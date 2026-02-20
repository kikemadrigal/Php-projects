<?php
class FileGame {
    private $id;
    private $name;
    private $path;
    private $game;
    function __construct($id){
		$this->id=$id;
	}
    function setName($name){
		$this->name=$name;
	}
	function setPath($path){
		$this->path=$path;
	}
    function setGame($game){
		$this->game=$game;
	}
	function getId(){
		return $this->id;	
	}
	function getName(){
		return $this->name;
	}
	function getPath(){
		return $this->path;
	}
    function getGame(){
		return $this->game;
	}
    function toString(){
		return "Filegame: Id: ".$this->id.", name: ".$this->name.", path: ".$this->path.", game: ".$this->game;	
	}
}
?>