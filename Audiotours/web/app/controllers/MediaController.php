<?php
class MediaController extends BaseController{
    private $validateInput;
    function __construct()
    {
        parent::__construct(); 
        $this->validateInput=new ValidateInput();
    }

    public function index(){
        $this->view->render("media/showAll");    
    }

    public function show($media=null){
        $media=MediaRepository::getMedia("images",$media[0]);
        $this->view->media=$media;
        $this->view->render("media/show");
    }

    
    public function showAll($media=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){
            $images=MediaRepository::getAll("images");
            $audios=MediaRepository::getAll("audios");
            $videos=MediaRepository::getAll("videos");
            $virtualTours=MediaRepository::getAllVirtualTours();
            $this->view->images=$images;
            $this->view->audios=$audios;
            $this->view->videos=$videos;
            $this->view->virtualTours=$virtualTours;
            $this->view->render("media/showAll");   
        }else{ 
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Error';</script>";
            header('Location: '.PATHSERVER."Error");
        }
    }

    //El insert contiene un select para asociar la foto a un tour
    public function insertForm(){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            $tours=TourRepository::getAll(0,2000);
            $this->view->tours=$tours;
            $this->view->render("media/insertForm");   
        }else{
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Error';</script>";       
            else header('Location: '.PATHSERVER."Error");
        }
    }
    //El insert contiene un select para asociar la foto a un tour
    public function insertFormVirtualTour(){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            $tours=TourRepository::getAll(0,2000);
            $this->view->tours=$tours;
            $this->view->render("media/insertFormVirtualTour");    
        }else{
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Error';</script>";       
            else header('Location: '.PATHSERVER."Error");
        }
    }


    public function insert(){
        if (isset($_POST['submit'])){
            $date=date("d-m-Y-H-i-s");
            $countImages=MediaRepository::getCountAutoincrement("images");
            $countAudios=MediaRepository::getCountAutoincrement("audios");
            $countVideos=MediaRepository::getCountAutoincrement("videos");
            
            //El 1 es el tour vacío
            $tourId=1;
            $tourId=$_POST['tourId'];
            //Le ponemos que no es un audio de cabecera para que se pueda boorar
            $isHeader=0;
            
            $name = $_FILES['file']['name']; 
            $tipo_archivo = $_FILES['file']['type']; 
            $tamano_archivo = $_FILES['file']['size']; 
            if (!(strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png")|| strpos($tipo_archivo, "mp3") || strpos($tipo_archivo, "mp4") || $tamano_archivo > 900000)) 
            {
                $this->validateInput->setErrors("La foto o el audio o video no tiene el formato o el tam&ntilde;o correcto, solo se aceptan mp3, jpg o png menores de 90Mb.");
            }else
            { 
                //1.Formateamos el nombre de la imagen
                $nameOnServer=Util::formatearTexto($name);
                $path="media/medias";
                $extension = FilesManager::getExtension($name);
                $extension=strtolower($extension);
                if( $extension=="png")$typeId=2;
                else if( $extension=="jpg")$typeId=3;
                else if( $extension=="jpeg")$typeId=4;
                else if( $extension=="gif")$typeId=5;
                else if( $extension=="mp3")$typeId=6;
                else if( $extension=="mp4")$typeId=7;
                else $typeId=1;


                
                //`id`, `name`, `path`, `date`, `typeId`, `userId`, `tourid`
                if($extension=="mp3"){
                    move_uploaded_file($_FILES['file']['tmp_name'], $path."/".$countAudios."-".$nameOnServer);
                    $lastId=MediaRepository::insertAudio($countAudios."-".$nameOnServer, $path, $isHeader,'' ,$typeId , $_SESSION['idusuario'], $tourId);    
                }else if($extension=="mp4"){
                    move_uploaded_file($_FILES['file']['tmp_name'], $path."/".$countVideos."-".$nameOnServer);
                    $lastId=MediaRepository::insertVideo($countVideos."-".$nameOnServer, $path, $isHeader,'' ,$typeId , $_SESSION['idusuario'], $tourId);    
                } else{
                    move_uploaded_file($_FILES['file']['tmp_name'], $path."/".$countImages."-".$nameOnServer);
                    $lastId=MediaRepository::insertImage($countImages."-".$nameOnServer, $path, $isHeader,'' ,$typeId , $_SESSION['idusuario'], $tourId);
                } 
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                else header('Location: '.PATHSERVER."Media/showAll");
            } 				
        } 
    }

    public function insertVirtualTour(){
        $tourId=$_POST['tourId'];
        $name=$_POST['name'];
        $typeId=8;

        $this->validateInput->validar_requerido("name",$name);
        $this->validateInput->validar_tamano_entre_2_a_254("name",$name);

        if(count($this->validateInput->getErrors())>0){   
            $this->view->name=$name;
            $this->view->errors=$this->validateInput->getErrors();
            $this->view->render("tour/insertFormVirtualTour");  
            die();
        }

        $lastId=MediaRepository::insertVirtualTour($name, '' ,$typeId , $_SESSION['idusuario'], $tourId);    
        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
        else header('Location: '.PATHSERVER."Media/showAll");

    }


    public function updateFormImage($image=null){
        $media=MediaRepository::getMedia("images",$image[0]);
        $this->view->media=$media;
        $this->view->render("media/update");
        //echo "vamos a  ver la imagen ".$image[0];
    }
    public function updateFormAudio($audio=null){
        $media=MediaRepository::getMedia("audios",$audio[0]);
        $this->view->media=$media;
        $this->view->render("media/update");
    }
    public function updateFormVideo($video=null){
        $media=MediaRepository::getMedia("videos",$video[0]);
        $this->view->media=$media;
        $this->view->render("media/update");
    }
    public function updateFormVirtualTour($virtualTour=null){
        $media=MediaRepository::getVirtualTour($virtualTour[0]);
        $this->view->media=$media;
        //echo "obtenido: ".$media->getId().", ".$media->getName().", ".$media->getTourId();
        $this->view->render("media/updateVirtualTour");
    }
    public function updateImage($media=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            if (isset($_POST['submit'])){
                $media=MediaRepository::getMedia("images",$_POST['id']);
                $media->setTourId($_POST['tourId']);
                MediaRepository::updateImage($media);
                
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                else header('Location: '.PATHSERVER."Media/showAll");
            }
        }
    }
    public function updateAudio($media=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            if (isset($_POST['submit'])){
                $media=MediaRepository::getMedia("audios",$_POST['id']);
                $media->setTourId($_POST['tourId']);
                MediaRepository::updateAudio($media);
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                else header('Location: '.PATHSERVER."Media/showAll");
            }
        }
    }
    public function updateVideo($media=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            if (isset($_POST['submit'])){
                $media=MediaRepository::getMedia("videos",$_POST['id']);
                $media->setTourId($_POST['tourId']);
                MediaRepository::updateVideo($media);
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                else header('Location: '.PATHSERVER."Media/showAll");
            }
        }
    }
    public function updateVirtualTour($media=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            if (isset($_POST['submit'])){
                $media=MediaRepository::getVirtualTour($_POST['id']);
                $media->setTourId($_POST['tourId']);
                $media->setName($_POST['name']);
                $this->validateInput->validar_requerido("name",$media->getName());
                $this->validateInput->validar_tamano_entre_2_a_254("name",$media->getName());
                if(count($this->validateInput->getErrors())>0){   
                    $this->view->name=$media->getName();
                    $this->view->errors=$this->validateInput->getErrors();
                    $this->view->render("tour/updateVirtualTour");  
                    die();
                }
                //echo "name".$media->getName().", ".$media->getTourId();
                MediaRepository::updateVirtualTour($media);
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                else header('Location: '.PATHSERVER."Media/showAll");
                
            }
        }
    }
    public function deleteImage(){
        if(isset($_POST['id']) && $_POST['id']!=1) {
            $idMedia=$_POST['id']; 
            if(empty($idMedia)) $this->validateInput->setErrors("idMedia not exits");
            else{
                $media=MediaRepository::getMedia("images",$idMedia);
                $success=MediaRepository::deleteMedia("images",$idMedia);
                if($success){
                    //Borramos el media si existe
                    $successDelete=unlink($media->getPath()."/".$media->getName());
                    if($successDelete){
                        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                        else header('Location: '.PATHSERVER."Media/showAll");
                    }else{
                        $this->validateInput->setErrors("It could not be erased on the server");
                    }
                }
                else{
                    $this->validateInput->setErrors("It does not exist in database");
                }
            } 
        }else{
            $this->validateInput->setErrors("idMedia not send");
        }
    }

    public function deleteAudio(){
        if(isset($_POST['id']) && $_POST['id']!=1) {
            $idMedia=$_POST['id']; 
            if(empty($idMedia)) $this->validateInput->setErrors("idMedia not exits");
            else{
                $media=MediaRepository::getMedia("audios",$idMedia);
                $success=MediaRepository::deleteMedia("audios",$idMedia);
                if($success){
                    //Borramos el media si existe
                    $successDelete=unlink($media->getPath()."/".$media->getName());
                    if($successDelete){
                        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                        else header('Location: '.PATHSERVER."Media/showAll");
                    }else{
                        $this->validateInput->setErrors("It could not be erased on the server");
                    }
                }
                else{
                    $this->validateInput->setErrors("It does not exist in database");
                }
            } 
        }else{
            $this->validateInput->setErrors("idMedia not send");
        }
    }
    public function deleteVideo(){
        if(isset($_POST['id']) && $_POST['id']!=1) {
            $idMedia=$_POST['id']; 
            if(empty($idMedia)) $this->validateInput->setErrors("idMedia not exits");
            else{
                $media=MediaRepository::getMedia("videos",$idMedia);
                $success=MediaRepository::deleteMedia("videos",$idMedia);
                if($success){
                    //Borramos el media si existe
                    $successDelete=unlink($media->getPath()."/".$media->getName());
                    if($successDelete){
                        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                        else header('Location: '.PATHSERVER."Media/showAll");
                    }else{
                        $this->validateInput->setErrors("It could not be erased on the server");
                    }
                }
                else{
                    $this->validateInput->setErrors("It does not exist in database");
                }
            } 
        }else{
            $this->validateInput->setErrors("idMedia not send");
        }
    }
    public function deleteVirtualTour(){
        if(isset($_POST['id']) && $_POST['id']!=1) {
            $idMedia=$_POST['id']; 
            if(empty($idMedia)) $this->validateInput->setErrors("idMedia not exits");
            else{
                $media=MediaRepository::getVirtualTour($idMedia);
                $success=MediaRepository::deleteVirtualTour($idMedia);
                if($success){
                    if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                    else header('Location: '.PATHSERVER."Media/showAll");
                }
                else{
                    $this->validateInput->setErrors("It does not exist in database");
                }
            } 
        }else{
            $this->validateInput->setErrors("idMedia not send");
        }
    }
}