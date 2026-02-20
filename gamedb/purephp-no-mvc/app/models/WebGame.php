<?php
class WebGame {
    private $id;
    private $text;
    private $game;
    function __construct($id){
		$this->id=$id;
	}
    function setText($text){
		$this->text=$text;
	}
    function setGame($game){
		$this->game=$game;
	}
	function getId(){
		return $this->id;	
	}
	function getText(){
		return $this->text;
	}
    function getGame(){
		return $this->game;
	}
    function toString(){
		return "WebGame: Id: ".$this->id.", text: ".$this->text.", game: ".$this->game;	
	}
}
?>