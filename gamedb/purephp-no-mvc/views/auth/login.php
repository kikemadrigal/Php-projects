<?php
$mensaje="";
if (isset($_POST['submit'])){
	$usuario=$_POST['nombreusuario'];
	$clave=$_POST['claveusuario'];
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	//1. Obtenemos el usuario por su nombre
	$consulta  = "SELECT * FROM users WHERE name='".$usuario."' ";
	$resultado=$basededatos->ejecutar_sql($consulta);
	$total_registros = mysqli_num_rows ($resultado);
	if($total_registros==false){
		$mensaje= "El nombre de usuario no existe.";
		header('Location: '.PATHSERVER."login");
		if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."login';</script>";
	}else{
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			if($linea['name']==$usuario){
				//2.Comprobamos su contraseña
				if($linea['password']==sha1($clave)){
					if( $linea['validate'] == '0'){
						$mensaje="El usuario necesita ser validado para continuar, vaya a:";
						$mensaje.="The user needs to be validated to continue, go to:";
						$mensaje.=PATHSERVER."mailValidation/".$linea[name]."/".$linea[password];
					//Si el usurio está ya validado...
					}else{
						$_SESSION['idusuario']=$linea['id'];
						?>
						<script type='text/javascript'>
							document.cookie = 'idusuario=<?php echo $linea['id'];?>; expires=Thu, 18 Dec 2080 12:00:00 UTC'; 
						</script>
						<?php
						$_SESSION['nombreusuario']=$linea['name'];
						$_SESSION['nivelaccesousuario']=$linea['role'];
						$mensaje="¡Hola!: ".$usuario;
						header('Location: '.PATHSERVER);
						if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."';</script>";
					}
				}else{
					$mensaje= "La clave del usuario ".$usuario." es incorrecta.<br>";
					$mensaje.="The user password ".$usuario." is incorrect.";
				}
			}else{
				echo "";
			}
		}
	}
	$basededatos->desconectar();
	//die();
}
include_once("./views/templates/document-start.php");
?>
<!--pattern: text El nombre debe de contener entre 4 y 15 letras o números sin espacios: pattern="[a-zA-Z0-9\d_]{0,50}" -->	
<!-- email: [a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5} -->
<div class="row col-md-4 offset-md-4 text-center bg-warning">
	<form name="loginform"  class='form-horizontal' id="loginform" action="<?php echo PATHSERVER."login" ?>" method="post">
		<div class="form-group m-4">
			<h3>Login</h3>
			<label for="error" class="control-label text-danger"><?php echo $mensaje;?></label>
		</div> 
		<!--m4= margin 4 en todos los lados-->
		<div class='form-group m-4'>
			<label for="nombreusuario" class='control-label'>Name</label>
			<input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title='Se necesita un nombre' placeholder="Nombre:" required />
		</div>
		<div class='form-group m-4'>
			<label for="claveusuario"  class='control-label'>Password</label>
			<input type="password" class="form-control" name="claveusuario" id="claveusuario"  title='Se necesita una clave' placeholder="Contrase&ntilde;a:" required />
		</div>
		<div class='form-group m-4' > 
			<input type="submit" name="submit" class="btn btn-primary btn-large" value="Acceder" />
			<br><a href="<?php echo PATHSERVER;?>recoveryPassword" class="control-label m-4" title="Recover your password">Have you lost your password??</a>
		</div> 
	</form>
</div>


