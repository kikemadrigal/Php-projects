<?php
class MapConfigure{
	private $id;
	private $locationAllow;
	private $latPosition;
	private $lngPosition;
	private $zoom;
	private $type;
	private $minMarkers;
	private $maxMarkers;
	private $timeStamp;
	private $idUser;
	function __construct($id,$locationAllow, $latPosition, $lngPosition, $zoom, $type, $minMarkers, $maxMarkers, $timeStamp, $idUser){
		$this->id=$id;
		$this->locationAllow=$locationAllow;
		$this->latPosition=$latPosition;
		$this->lngPosition=$lngPosition;
		$this->zoom=$zoom;
		$this->type=$type;
		$this->minMarkers=$minMarkers;
		$this->maxMarkers=$maxMarkers;
		$this->timeStamp=$timeStamp;
		$this->idUser=$idUser;
	}

	public function setLatPosition($latPosition){
		$this->latPosition=$latPosition;
	}
	public function setLngPosition($lngPosition){
		$this->lngPosition=$lngPosition;
	}
	public function getId(){
		return $this->id;
	}
	public function getLocationAllow(){
		return $this->locationAllow;
	}
	public function getLatPosition(){
		return $this->latPosition;
	}
	public function getLngPosition(){
		return $this->lngPosition;
	}
	public function getZoom(){
		return $this->zoom;
	}
	public function getType(){
		return $this->type;
	}
	public function getMinMarkers(){
		return $this->minMarkers;
	}
	public function getMaxMarkers(){
		return $this->maxMarkers;
	}
	public function getTimeStamp(){
		return $this->timeStamp;
	}
	public function getIdUser(){
		return $this->idUser;
	}
}
?>