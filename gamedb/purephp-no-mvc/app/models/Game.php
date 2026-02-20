<?php

Class Game {
	private $id;
	private $title;
	private $cover;
	private $instructions;
	private $country;
	private $publisher;
	private $developer;
	private $year;
	//format: cassete,disk, cardbridge
	private $format;
	//genre: puzzle, Strategy
	private $genre;
	private $system;
	//programming: MSX Basic, assambler
	private $programming;
	//sound:psg, scc, fm
	private $sound;
	//control: keyboard
	private $control;
	//players: 1,2
	private $players;
	//languages: spanish, english
	private $languages;
	private $file;
	private $screenshot;
	private $video;
	private $web;
	//iGoIt: yes, no
	private $iGoIt;
	//Roto?
	private $broken;
	//observations: la carátula es una fotocopia, el plástico no tiene la marca cbs
	private $observations;

	
	/**
	 * CONSTRUCTOR
	 */
	function __construct($id){
		$this->id=$id;
	}
	

	/**
	 * SETTERS
	 */
	function setTitle($title){
		$this->title=$title;
	}
	function setCover($cover){
		$this->cover=$cover;
	}
	function setInstructions($instructions){
		$this->instructions=$instructions;
	}
	function setCountry($country){
		$this->country=$country;
	}
	function setPublisher($publisher){
		$this->publisher=$publisher;
	}
	function setDeveloper($developer){
		$this->developer=$developer;
	}
	function setYear($year){
		$this->year=$year;
	}
	function setFormat($format){
		$this->format=$format;
	}
	function setGenre($genre){
		$this->genre=$genre;
	}
	function setSystem($system){
		$this->system=$system;
	}
	function setProgramming($programming){
		$this->programming=$programming;
	}
	function setSound($sound){
		$this->sound=$sound;
	}
	function setControl($control){
		$this->control=$control;
	}
	function setPlayers($players){
		$this->players=$players;
	}
	function setLanguages($languages){
		$this->languages=$languages;
	}
	function setFile($file){
		$this->file=$file;
	}
	function setScreenshot($screenshot){
		$this->screenshot=$screenshot;
	}
	function setVideo($video){
		$this->video=$video;
	}
	function setWeb($web){
		$this->web=$web;
	}
	function setIGoIt($iGoIt){
		$this->iGoIt=$iGoIt;
	}
	function setBroken($broken){
		$this->broken=$broken;
	}
	function setObservations($observations){
		$this->observations=$observations;
	}

	








	/**
	 * GETTERS
	 */
	function getId(){
		return $this->id;	
	}
	function getTitle(){
		return $this->title;
	}
	function getCover(){
		return $this->cover;
	}
	function getInstructions(){
		return $this->instructions;
	}
	function getCountry(){
		return $this->country;
	}
	function getPublisher(){
		return $this->publisher;
	}
	function getDeveloper(){
		return $this->developer;
	}
	function getYear(){
		return $this->year;
	}
	function getFormat(){
		return $this->format;
	}
	function getGenre(){
		return $this->genre;
	}
	function getSystem(){
		return $this->system;
	}
	function getProgramming(){
		return $this->programming;
	}
	function getSound(){
		return $this->sound;
	}
	function getControl(){
		return $this->control;
	}
	function getPlayers(){
		return $this->players;
	}
	function getLanguages(){
		return $this->languages;
	}
	function getFile(){
		return $this->file;
	}
	function getScreenshot(){
		return $this->screenshot;
	}
	function getVideo(){
		return $this->video;
	}
	function getWeb(){
		return $this->web;
	}
	function getIGoIt(){
		return $this->iGoIt;
	}
	function getBroken(){
		return $this->broken;
	}
	function getObservations(){
		return $this->observations;
	}

	
	
	
	/**
	 * TODTRING
	 */
	function toString(){
		return"Id: ".$this->id.", title: ".$this->title.", cover: ".$this->cover.", instructions: ".$this->instructions.", country: ".$this->country.", publisher: ".$this->publisher.", developer: ".$this->developer.", year: ".$this->year.", format: ".$this->format.", genre: ".$this->genre.", system: ".$this->system.", programming: ".$this->programming.", sound: ".$this->sound.", control: ".$this->control.", players: ".$this->players.", languages: ".$this->languages.", file: ".$this->file.", screenshot: ".$this->screenshot.", video: ".$this->video.", web: ".$this->web.", iGoIt: ".$this->iGoIt.", broken: ".$this->broken.", observations: ".$this->observations;	
	}
	function toStringCSV(){
		return $this->id."\, ".$this->title."\, ".$this->cover."\, ".$this->instructions."\, ".$this->country."\, ".$this->publisher."\, ".$this->developer."\, ".$this->year."\, ".$this->format."\, ".$this->genre."\, ".$this->system."\, ".$this->programming."\, ".$this->sound."\, ".$this->control."\, ".$this->players."\, ".$this->languages."\, ".$this->file."\, ".$this->screenshot."\,".$this->video."\, ".$this->web."\, ".$this->iGoIt."\, ".$this->broken."\, ".$this->observations;	
	}
	function toStringSimple(){
		return"Id: ".$this->id.", title: ".$this->title;
	}
	
	
}

?>