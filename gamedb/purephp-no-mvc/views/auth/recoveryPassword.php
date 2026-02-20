<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$mensaje="";
$codigoActivacion=null;
if (isset($_POST['submit'])){
    $existeCorreo=UserRepository::comprobarSiExisteCoreoYaRegistrado($_POST['email']);
    if ($existeCorreo){
        $correoUsuario=$_POST['email'];
        $usuario=UserRepository::obtenerNombreusuarioAtravesDeCorreo($_POST['email']);
        $fecha=date("d/m/Y");
        $codigoActivacion=sha1(UserRepository::generarCodigoActivacion(20,false));
        //Tenemos que guardar la contraseña hash generada automáticamente en la base de datos, le pondremos un 0 a usuario validado
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="INSERT INTO users (password)  VALUES ( '$codigoActivacion') ";
        //$sql="INSERT INTO users (id, name, password, role, email, realName, surname, web, validate, counter, date, observations)  VALUES ( '', 'juan','12345', '3', 'juan@hotmail.com','nombre real', 'Sin apellido', 'Sin web', '0', 0, '12/12/2022', 'clave generada por defecto') ";
        if($bd->ejecutar_sql($sql)==null){
            $mensaje="Error, no se pudo crear el usuario.";
        }
        $bd->desconectar();
        if (PRODUCTION==1){
            /****************************************
                            PRODUCTION                    
            ****************************************/ 
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
            require_once "./libraries/PHPMailer/Exception.php";
            require_once "./libraries/PHPMailer/PHPMailer.php";
            require_once "./libraries/PHPMailer/SMTP.php";

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
                $link="<p> <a href='".PATHSERVER."mailValidation"."/".$usuario."/".$codigoActivacion."'>Pincha en este enlace para recuperar tu cuenta en gamesdb.tipolisto.es<br>Click on this link to recover your account at tipolisto.es</a></p>";  
                $mail->Body    = "<html>  
                                    <head> 
                                        <title>gamesdb.tipolisto.es</title>                                 
                                    </head> 
                                    <body>
                                    ".$link."
                                    </body>  
                                </html>";
                $mail->send();
                $mensaje="Revisa el correo ".$correoUsuario." para la activación, revisa el correo no deseado.<br>Check the email ".$correoUsuario." for activation, check spam.";
            } catch (Exception $e) {
                $mensaje= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }//Fin de si es la versión de desarrollo o producción


    }else{
        $mensaje="The mail does not exist / Este correo ya existe.";
    }
}
include_once("./views/templates/document-start.php");
?>
<div class="row text-center">		
    <h3>Enter your email</h3>
    <form class="form-horizontal col-lg-6 offset-lg-3" name="resetPasswordForm" id="resetPasswordForm" action="<?php echo PATHSERVER."recoveryPassword"?>" method="post">
    <div class="form-group">
            <label for="error" class="control-label text-danger"><?php echo $mensaje;?></label>
    </div>    
    <div class="form-group">
            <label for="email" class="control-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" placeholder="email" required />
    </div>
       
    <p>You will receive a password in this email.</p>
        <br />
        <input type="hidden" name="codigoActivacion" id="codigoActivacion" value="<?php echo $codigoActivacion; ?>"  >
        <div class="form-group" > 
            <div class="col-md-offset-2" >
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Reset password" />
            </div>
        </div> 
    </form>
    
</div>
<?php include_once("./views/templates/document-end.php");?>