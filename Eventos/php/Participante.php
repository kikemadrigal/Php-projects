<?php
class Participante{
    private $id;
    private $nombre;
    private $asistencia;
    private $pagado;
    private $comentario;
    private $id_evento;

    public function __construct($id, $nombre, $asistencia, $pagado, $comentario, $id_evento){
        $this->id=$id;
        $this->nombre=$nombre;
        $this->asistencia=$asistencia;
        $this->pagado=$pagado;
        $this->comentario=$comentario;
        $this->id_evento=$id_evento;
    }

    public function get_id(){
        return $this->id;
    }

    public function get_nombre(){
        return $this->nombre;
    }

    public function get_asistencia(){
        return $this->asistencia;
    }

    public function get_pagado(){
        return $this->pagado;
    }

    public function get_comentario(){
        return $this->comentario;
    }

    public function get_id_evento(){
        return $this->id_evento;
    }
    public function set_id($id){
        $this->id=$id;
    }
    public function set_nombre($nombre){
        $this->nombre=$nombre;
    }
    public function set_asistencia($asistencia){
        $this->asistencia=$asistencia;
    }
    public function set_pagado($pagado){
        $this->pagado=$pagado;
    }
    public function set_comentario($comentario){
        $this->comentario=$comentario;
    }
    public function set_id_evento($id_evento){
        $this->id_evento=$id_evento;
    }
}