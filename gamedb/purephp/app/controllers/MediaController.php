<?php
class MediaController extends BaseController{
    function __construct()
    {
        parent::__construct(); 
    }

    public function index(){
        $this->view->render("media/showAll");    
    }
    public function showAll(){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
            $this->view->render("media/showAllUser");   
        }else if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            $this->view->render("media/showAll"); 
        }
    }
    public function insert(){
        $this->view->render("media/insert");    
    }
    public function update(){
        $this->view->render("media/update");    
    }
    public function delete(){
        $this->view->render("media/delete");    
    }
}