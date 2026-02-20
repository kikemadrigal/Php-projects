<?php 
//showUnregisteredView.php muestra una vista especial para seleccionar usuarios y ver todos sus juegos
include_once("./views/templates/document-start.php"); 
if (isset($_POST['submit'])){
    //Aquí no hay que utilizar la sesión porque queremos ver el usuario que viene sin logearse
	$idUser=$_POST['idUser'];
    //getAllGamesByUserAndField($idUser, $field, $value, $start, $end)
    //$games=GameUserRepository::getGameUserByTitle($idUser,0,50);
    $games=GameUserRepository::getAllGamesByUser($idUser,0,1000);
    
}

?>

<div class="row">
    <div class="col col-md-4 background-blue">
        <h3>Select User</h3>
        <form name="searchByUserForm"  class='form-horizontal' id="searchByUserForm" action="<?php echo PATHSERVER."Game/showUnregisteredView" ?>" method="post">
            <?php
            $users=UserRepository::getALLUsers();
            echo "<select class='m-4' name='idUser' id='iduser' > ";
            foreach ($users as $posicion=>$user){
                echo "<option value='".$user->getId()."' >".$user->getName()."</option>";
            }
            echo "</select>";
            ?>
            <input type="submit" name="submit" class="btn btn-primary btn-large" value="Show" />
        </form>
    </div> 


    <div class='col col-md-8'>
        <h3>Select game user</h3>
        <p>With the red frame they don't work</p>
        <?php 
        if (isset($_POST['idUser'])){
            ?>
            <form class="d-flex col-md-4" method=post action='<?php echo PATHSERVER; ?>Game/showUnregisteredView'>
                <input class="form-control" type="search" name="search" id="search" placeholder="Search your games" aria-label="search your games">
                <input type="hidden" name="idUserSearch" value="<?php echo $_POST['idUser'] ?>" />
                <button class="btn btn-outline-success" type="submit" name="submitSearch">Search</button>
            </form>
            <?php
            foreach ($games as $posicion=>$game){
                if($game->getBroken()==1){
                    echo "<a href='".PATHSERVER."Game/showUser/".$game->getId()."' class='juego-roto'>".Util::cortarCadena($game->getTitle())."</a><br>";
                }else{
                    echo "<a href='".PATHSERVER."Game/showUser/".$game->getId()."'>".Util::cortarCadena($game->getTitle())."</a><br>";
                }
                
            }
            ?>

            <?php
        }
        //Esto es el campo de buscar juego de usuario que aparece
        if(isset($_POST['submitSearch'])){
            ?>
            <form class="d-flex col-md-4" method=post action='<?php echo PATHSERVER; ?>Game/showUnregisteredView'>
                <input class="form-control" type="search" name="search" id="search" placeholder="Search your games" aria-label="search your games">
                <input type="hidden" name="idUserSearch" value="<?php echo $_POST['idUserSearch'] ?>" />
                <button class="btn btn-outline-success" type="submit" name="submitSearch">Search</button>
            </form>

            <?php
            //getAllGamesByUserAndField($idUser, $field, $value, $start, $end)
            $games=GameUserRepository::getAllGamesByUserAndField($_POST['idUserSearch'],"title",$_POST['search'],0,1000);
            foreach ($games as $posicion=>$game){
                if($game->getBroken()==1){
                    echo "<a href='".PATHSERVER."game/showUser/".$game->getId()."' class='juego-roto'>".Util::cortarCadena($game->getTitle())."</a><br>";
                }else{
                    echo "<a href='".PATHSERVER."game/showUser/".$game->getId()."'>".Util::cortarCadena($game->getTitle())."</a><br>";
                }
            }
        }
        ?>
    </div>
</div>








<?php include_once("./views/templates/document-end.php"); ?>