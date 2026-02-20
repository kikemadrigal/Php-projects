<?php
class SettingsController extends BaseController{
    function __construct()
    {
        parent::__construct(); 
    }

    public function index(){
        $this->view->render("settings");    
    }
}