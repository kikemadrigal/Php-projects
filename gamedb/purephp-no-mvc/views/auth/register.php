<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensaje="";
$codigoActivacion=null;
if (isset($_POST['submit'])){
    $existeCorreo=UserRepository::comprobarSiExisteCoreoYaRegistrado($_POST['correousuario']);
    if ($existeCorreo){
       $mensaje="Este correo ya existe.";
    }else{
        $correoUsuario=$_POST['correousuario'];
        $usuario=$_POST['nombreusuario'];
        $fecha=date("d/m/Y");
        $codigoActivacion=sha1(UserRepository::generarCodigoActivacion(20,false));
        //Tenemos que guardar la contraseña hash generada automáticamente en la base de datos, le pondremos un 0 a usuario validado
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="INSERT INTO users (id, name, password, role, email, realName, surname, web, validate, counter, date, view, token, observations)  VALUES ( '', '$usuario','$codigoActivacion', '3', '$correoUsuario', ' ', ' ', ' ', '0', 0, '$fecha', 2,'', 'clave generada por defecto') ";
        //$sql="INSERT INTO users (id, name, password, role, email, realName, surname, web, validate, counter, date, observations)  VALUES ( '', 'juan','12345', '3', 'juan@hotmail.com','nombre real', 'Sin apellido', 'Sin web', '0', 0, '12/12/2022', 'clave generada por defecto') ";
        if($bd->ejecutar_sql($sql)){
            $mensaje="Error, no se pudo crear el usuario.";
        }
        $bd->desconectar();
        /****************************************
                            PRODUCTION                    
        ****************************************/ 
        if (PRODUCTION==1){

            $subject = "New message from gamesdb.tipolisto.es";
            $message="Pincha en este enlace para recuperar tu cuenta en gamesdb.tipolisto.es<br>Click on this link to recover your account at tipolisto.es";
            $message .=" ".PATHSERVER."mailValidation"."/".$usuario."/".$codigoActivacion." ";  
            
            if (mail($correoUsuario,$subject,$message)){
                $mensaje="Revisa el correo ".$correoUsuario." para la activación, revisa el correo no deseado.<br>Check the email ".$correoUsuario." for activation, check spam.";
            }else{
                $mensaje= "Mensaje fallido";
            } 
        }else{
            /****************************************
                            DEVELOPMENT                    
            ****************************************/ 
            require "./libraries/PHPMailer/Exception.php";
            require "./libraries/PHPMailer/PHPMailer.php";
            require "./libraries/PHPMailer/SMTP.php";
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = EMAILSERVER;                     //SMTP username
                $mail->Password   = EMAILPASSWORD;                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;        
                //Desde donde se va a enviar
                $mail->setFrom(EMAILSERVER, EMAILUSER);
                //a quien se le va a enviar
                $mail->addAddress($correoUsuario, $usuario);    
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject =  "New message from gamesdb.tipolisto.es";
                $link="<a href='".PATHSERVER."mailValidation"."/".$usuario."/".$codigoActivacion."'>Pincha en este enlace para validar tu cuenta en gamesdb.tipolisto.es<br>Click on this link to validate your account at tipolisto.es</a>";  
                $mail->Body    = "<html><head><title>gamesdb.tipolisto.es</title></head><body>".$link."</body> </html>";
                $mail->send();
                $mensaje="Revisa el correo ".$correoUsuario." para la activación.<br>Check the email ".$correoUsuario." for activation.";
            } catch (Exception $e) {
                $mensaje= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }//Fin de si es la versión de producción o desarrollo
    }
}
include_once("./views/templates/document-start.php");
?>
<!--pattern: text El nombre debe de contener entre 4 y 15 letras o números sin espacios: pattern="[a-zA-Z0-9\d_]{4,15}" -->	
<!-- email: [a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5} -->
<div class="row col-md-4 offset-md-4 text-center bg-warning">		
    <form class="form-horizontal" name="registerform" id="registerform" action="<?php echo PATHSERVER."register"?>" method="post">
        <div class="form-group m-4">
            <h3>Register on this site</h3>
            <label for="error" class="control-label text-danger"><?php echo $mensaje;?></label>
        </div>    
        <div class="form-group m-4">
            <label for="nombreusuario" class="control-label">Name</label>
            <input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title="El nombre debe de contener entre 4 y 15 letras o números sin espacios" placeholder="Nombre:" pattern="[a-zA-Z0-9\d_]{4,15}" required />
        </div>
        <div class="form-group m-4">
            <label for="correousuario" class="control-label">Email:</label>
            <input type="email" class="form-control" name="correousuario" id="correousuario" placeholder="Correo:" required />
        </div> 
        <p>You will receive a password in this email.</p>
        <br />
         <div class="form-group m-4" > 
            <div class="col-md-offset-2" >
                <input type="hidden" name="codigoActivacion" id="codigoActivacion" value="<?php echo $codigoActivacion; ?>"  >
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Registrarse" />
            </div>
        </div> 
    </form>
    <p><a href="<?php echo PATHSERVER."login";?>">Login </a> | <a href="gestionarusuarios.php?accion=30" title="Recovery your password">Did you forget your password?</a></p>
    <p><a href="<?php echo PATHSERVER;?>" title=" | Are you lost?">return gamedb</a></p>
</div>
<?php
include_once("./views/templates/document-end.php");	
?>