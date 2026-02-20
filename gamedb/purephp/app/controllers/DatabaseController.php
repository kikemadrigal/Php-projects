<?php
class DatabaseController extends BaseController{
    function __construct()
    {
        parent::__construct(); 
    }

    public function index(){
        $this->view->render("database/show");    
    }
    public function show(){
        $this->view->render("database/show");    
    }
    public function csv(){
        $this->view->render("database/csv");    
    }
    public function mysql(){
        $this->view->render("database/mysql");    
    }
    public function sqlite(){
        $this->view->render("database/sqlite");    
    }
}