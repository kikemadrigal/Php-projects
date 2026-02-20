<?php
require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ValidacionesFormularioNuevoUsuario.php" );
require_once( "app/RepositorioUserMessages.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/RepositorioUserResetPassword.php" );
require_once( "app/ValidacionesFormularioReseteoClave.php");
require_once( "app/Usuario.php" );
$idUsuario=null;
Conexion::abrir_conexion();

//1.Vemos si la clave de activacion fue incuida en la base de datos userrestpassword
if(RepositorioUserResetPassword::claveActivacionExiste(Conexion::obtener_conexion(),$claveActivacion)){
	$idUsuario=RepositorioUserResetPassword::get(Conexion::obtener_conexion(),$claveActivacion);
}else{
	//echo "<h2>Clave de activacion no no existe</h2>";
	//RepositorioUserMessages::stored(Conexion::obtener_conexion(),"La clave no existe","IP:".$_SERVER['REMOTE_ADDR']);
	//echo "<script type='text/javascript'>location.href='".RUTA_HOME."'</script>";
}
if ( isset( $_POST[ 'buttonSubmiformloginresetpassword' ] ) ) {
	$clavesvalidadas=new ValidacionesFormularioReseteoClave(Conexion::obtener_conexion(),$_POST['claveusuario'],$_POST['claveusuariodos']);
	//Si están validadas las claves
	if($clavesvalidadas->registroValido()){
		$actualizado=RepositorioUsuario::actualizarClaveUsuario(Conexion::obtener_conexion(), $_POST['idUsuario'], password_hash($_POST['claveusuario'], PASSWORD_DEFAULT));
		$borrado=RepositorioUserResetPassword::delete(Conexion::obtener_conexion(),$_POST['idUsuario']);
		//echo "<h2>Borrado: ".$borrado.", actualizado: ".$actualizado."</h2>";
		if($actualizado){
			RepositorioUserMessages::stored(Conexion::obtener_conexion(),"Clave actualizada","IP:".$_SERVER['REMOTE_ADDR']);
			echo "<script type='text/javascript'>location.href='".RUTA_LOGIN."'</script>";
		}else{
			RepositorioUserMessages::stored(Conexion::obtener_conexion(),"Clave no actualizada","IP:".$_SERVER['REMOTE_ADDR']);
			echo "<script type='text/javascript'>location.href='".RUTA_HOME."'</script>";
		}
	}
	
}
Conexion::cerrar_conexion();

include_once("views/layouts/document-start.inc.php");
//echo "<h1>correo: ".$_GET['correousuario']."</h1>";
?>
	 <div class="container">
		 <div class='alert alert-danger' role='alert'>Por favor, modifica tu contrase&ntilde;a: que se asign&oacute; por defecto.</div> 
		  <form  id='formloginresetpassword' name='formloginresetpassword' class='form-horizontal' method='post' action="<?php echo RUTA_OLVIDO_CLAVE_DOS; ?>"> 
			  <div class='form-group' > 
              		<label for='claveusuario' class='control-label col-md-4'>Contrase&ntilde;a nueva</label>
		            <div class='col-md-6'>
                     <input type='password'  class='form-control' id='claveusuario' name='claveusuario' required ></input> 
                    </div>
                    <!-- solo se mostrará en caso de error-->
                    <?php
                    if ( isset( $_POST[ 'buttonSubmiformloginresetpassword' ] ) ) {
                    	 echo $clavesvalidadas->mostrarErrorClave1(); 
                    }
			  		?>
		     </div>  	    
		     <div class='form-group' >   
             		 <label for='claveusuariodos' class='control-label col-md-4'>Repita la nueva contrase&ntilde;a:</label>
		             <div class='col-md-6'>
                        <input type='password' class='form-control' id='claveusuariodos' name='claveusuariodos' required></input>  
                     </div>
                     <!-- solo se mostrará en caso de error-->
                     <?php
                    if ( isset( $_POST[ 'buttonSubmiformloginresetpassword' ] ) ) {
                      echo $clavesvalidadas->mostrarErrorClave2(); 
					}
		 			?>
		      </div>  
              <input type='hidden' id='idUsuario' name='idUsuario' value="<?php echo $idUsuario; ?>" ></input>  
		     <div class='form-group' > 
		         <div class='col-md-6 col-md-offset-4' >
                      <input type='submit' id='buttonSubmiformloginresetpassword' name='buttonSubmiformloginresetpassword' value='Actualizar' class="btn btn-primary"  />
				 </div>
		     </div> 
		   </form>  
           <div id="textoClave">&nbsp;</div>
     </div>
<?php
include_once("views/layouts/document-end.inc.php");
?>