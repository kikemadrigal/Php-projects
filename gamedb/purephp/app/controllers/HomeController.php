<?php

class HomeController extends BaseController{
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->view->render("home");
    }
}