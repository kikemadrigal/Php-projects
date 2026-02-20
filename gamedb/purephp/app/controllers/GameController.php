<?php
class GameController extends BaseController{
    
    function __construct()
    {
        parent::__construct();
    }


    public function index(){
        $this->view->render("game/showByCategoriesUsers");
    }
    public function show($param=null){
        $this->view->param=$param;
        $this->view->render("game/show");
    }
    public function showUser($param = null){
        $this->view->param=$param;
        //echo "<h3>Entraaaa-->".$param[0]."</h3>";
        $this->view->render("game/showUser");
    }
    //showUnregisteredView.php muestra una vista especial para seleccionar usuarios y ver todos sus juegos
    public function showUnregisteredView(){
        $this->view->render("game/showUnregisteredView");
    }
    public function showByCategoriesUsers(){
        $this->view->render("game/showByCategoriesUsers");
    }
    public function search($search = null){
        $this->view->param=$search[0];
        $this->view->render("game/search");
    }
    public function searchUser($search = null){
        $this->view->param=$search[0];
        $this->view->render("game/search");
    }



    public function insert(){
        $this->view->render("game/insertUser");
    }
    public function update($id=null){
        $this->view->param=$id[0];
        $this->view->render("game/updateUser");
    }
    public function delete($id=null){
        $this->view->param=$id[0];
        $this->view->render("game/deleteUser");
    }
}