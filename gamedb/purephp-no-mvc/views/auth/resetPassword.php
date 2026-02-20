<?php 
$mensaje="";
if (isset($_POST['submit'])){
    if($_POST['password1']!=$_POST['password2']){
        $mensaje="different password";
    }else{
        $claveUsuario=sha1($_POST['password1']);
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="update users set password='$claveUsuario', validate=1 where id='$_SESSION[idusuario]'";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
        ?>
        <script type='text/javascript'>
            document.cookie = 'idusuario=<?php echo $idUsuario;?>; expires=Thu, 18 Dec 2080 12:00:00 UTC'; 
        </script>
        <?php
        header('Location: '.PATHSERVER."user/update");
        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."user/update';</script>";
    }
}
include_once("./views/templates/document-start.php");
?>
<div class="row text-center">		
    <h3>Enter your new password</h3>
    <form class="form-horizontal col-lg-6 offset-lg-3" name="resetPasswordForm" id="resetPasswordForm" action="<?php echo PATHSERVER."resetPassword"?>" method="post">
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
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Reset password" />
                <input type="hidden" name="id" value="<?php echo $_SESSION['idusuario'] ?>" />
            </div>
        </div> 
    </form>
    
</div>
<?php include_once("./views/templates/document-end.php");?>