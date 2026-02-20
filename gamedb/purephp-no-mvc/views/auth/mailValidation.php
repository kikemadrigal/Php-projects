<?php
//En el index obtenemos el 
//$nombreUsuario=$partesRuta[2];
//$codigoDeActivacion=$partesRuta[3];
$mensaje="";
if (isset($_POST['submit'])){
    //echo "<h1>Eexiste submit</h1>";
    //Si son distintas las contraseñas las actualizamos en la base de datos, también ponemos que el usuario está validado a 1
    if($_POST['password1']!=$_POST['password2']){
        $mensaje="different password";
    }else{
        $claveUsuario=sha1($_POST['password1']);
        $idUsuario=UserRepository::obteneridusuario($_POST['nombreUsuario']);
        $mensaje="usuario ".$_POST['nombreUsuario']." actualizado.";
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="update users set password='$claveUsuario', validate=1 where id='$idUsuario'";
        //echo "id ".$idUsuario.", clave: ".$claveUsuario;
        $bd->ejecutar_sql($sql);
        $bd->desconectar();

        $_SESSION['idusuario']=$idUsuario;
        ?>
        <script type='text/javascript'>
            document.cookie = 'idusuario=<?php echo $idUsuario;?>; expires=Thu, 18 Dec 2080 12:00:00 UTC'; 
        </script>
        <?php
        $_SESSION['nombreusuario']=$_POST['nombreUsuario'];
        $_SESSION['nivelaccesousuario']=UserRepository::obtenerNivelAccesoAtravesDeIdUsuario($idUsuario);
        header('Location: '.PATHSERVER."home");
        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."home';</script>";
    }

}else{
    //Comprobamos que el código hash de la url es el mismo que el de la base de datos
    $basededatos= new MysqliClient();
    $basededatos->conectar_mysql();
    $consulta  = "SELECT id, password FROM users WHERE name='".$nombreUsuario."'";
    $resultado=$basededatos->ejecutar_sql($consulta);
    while ($linea = mysqli_fetch_array($resultado )) 
    {
        if($linea['password']==$codigoDeActivacion){
            $idusuario=$linea['id'];
            $mensaje="Usuario validado, ahora puedes utilizar la web! ".$nombreUsuario."<br>";
            $mensaje.="Validated user, now you can use the web!".$nombreUsuario."<br>";
        }
    }
    $basededatos->desconectar();
}

//enviarCorreoAlAdministrador("En gestorwebs se ha confirmado el usuario: ".$nombreusuario.", se le han creado las tablas.");
include_once("./views/templates/document-start.php");
?>
<div class="row text-center">		
    <h3>Enter your password</h3>
    <form class="form-horizontal col-lg-6 offset-lg-3" name="registerform" id="registerform" action="<?php echo PATHSERVER."mailValidation"?>" method="post">
    <div class="form-group">
            <label for="error" class="control-label fs-1 fw-bold text-warning"><?php echo $mensaje;?></label>
    </div>    
    <div class="form-group">
            <label for="password1" class="control-label">Password</label>
            <input type="password" class="form-control" name="password1" id="password1" title="The name must contain between 4 and 15 letters or numbers without spaces" placeholder="password 1" pattern="[a-zA-Z0-9\d_]{4,15}" required />
        </div>
        <div class="form-group">
            <label for="password2" class="control-label">Repeat password:</label>
            <input type="password" class="form-control" name="password2" id="password2"  placeholder="password 2" pattern="[a-zA-Z0-9\d_]{4,15}" required />
        </div> 
        <div class="form-group" > 
            <div class="col-md-offset-2" >
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Registrarse" />
                <input type="hidden" name="nombreUsuario" value="<?php echo $nombreUsuario ?>" />
            </div>
        </div> 
    </form>
    <p><a href="<?php echo PATHSERVER."login";?>">Login</a> |<a href=""<?php echo PATHSERVER."recoverPassword";?>" title="Recover your password">Did you forget your password?</a></p>
    <p><a href="index.php" title="¿Te has perdido?">Volver a Gestor de webs</a></p>
</div>
<?php include_once("./views/templates/document-end.php");	


