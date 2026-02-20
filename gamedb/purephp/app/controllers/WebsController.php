<?php
class WebsController extends BaseController{
    function __construct()
    {
        parent::__construct(); 
    }

    public function index(){
        $this->view->render("webs");    
    }
}