<?php
require_once('RepositorioUsuario.php');
class ValidacionesFormularioNuevoUsuario{
	private $nombre;
	private $email;
	private $clave1;
	private $clave2;
	private $errorNombre;
	private $errorEmail;
	private $errorClave1;
	private $errorClave2;
	function __construct($conexion,$nombre,$email,$clave1,$clave2){
		$this->nombre="";
		$this->email="";
		$this->clave1=$clave1;
		$this->clave2=$clave1;
		$this->errorNombre=$this->validarNombre($conexion,$nombre);
		$this->errorEmail=$this->validarEmail($conexion,$email);
		$this->errorClave1=$this->validarClave1($clave1);
		$this->errorClave2=$this->validarClave2($clave1,$clave2);
	}
	private function varibleVacia($variable){
		if(isset($variable) && !empty($variable)){
			return true;
		}
		else{
			return false;
		}
	}
	private function validarNombre($conexion,$nombre){
		if (!$this->varibleVacia($nombre)){
			return "Debes de escribir un nombre de usuario";
		}else{
			$this->nombre=$nombre;
		}
		if(strlen($nombre)<4){
			return  "El nombre debe tener más de 4 carácteres.";
		}
		
		if(strlen($nombre)>15){
			return "El nombre no puede ser mayor de 15 caracteres.";
		}
		//Comprobamos si el nombre existe
		if(RepositorioUsuario::comprobarSiExisteNombre($conexion,$nombre)){
			return "El nombre de usuario ya existe.";
		}
		return "";
	}
	private function validarEmail($conexion,$email){
		if (!$this->varibleVacia($email)){
			return "Debes de escribir un email.";
		}else{
			$this->email=$email;
		}
		if(strlen($email)<4){
			return "El email debe tener más de 4 carácteres.";
		}
		if(RepositorioUsuario::comprobarSiExisteEmail($conexion,$email)){
			return "El email ya existe o <a href='loginresetpassword.php'>Intente recuperar su conraseña</a>";
		}
		return "";
	}
	private function validarClave1($clave1){
		if (!$this->varibleVacia($clave1)){
			return "Debes de escribir una contraseña.";
		}
		return "";
	}
	private function validarClave2($clave1, $clave2){
		if (!$this->varibleVacia($clave1)){
			return "Debes de poner la contraseña.";
		}
		if (!$this->varibleVacia($clave2)){
			return "Debes repetir la contraseña.";
		}
		if($clave1!==$clave2){
			return "Ambas contraseñas deben coincidir";
		}
		return "";
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getClave1(){
		return $this->clave1;
	}
	public function getErrorNombre(){
		return $this->errorNombre;
	}
	public function getErrorEmail(){
		return $this->errorEmail;
	}
	public function getErrorClave1(){
		return $this->errorClave1;
	}
	public function getErrorClave2(){
		return $this->errorClave2;
	}
	
	
	/*************Errores nombre******************************/
	//Este código está enlazado con el input nombreusuario de formusercreatevalidate.php y con el div de debajo suyo
	public function mostrarNombre(){
		if($this->nombre!==''){
			echo 'value="'.$this->nombre.'"';
		}
	}
	public function mostrarErrorNombre(){
		if($this->errorNombre!==''){
			echo "<br><div class='alert alert-danger' role='alert'>".$this->errorNombre."</div>";
		}
	}
	/**************Fin de errores nombre*********************/
	
	
	/*************Errores email*****************************/
	//Este código está enlazado con el input emailusuario de formusercreatevalidate.php y con el div de debajo suyo
	public function mostrarEmail(){
		if($this->email!==''){
			echo 'value="'.$this->email.'"';
		}
	}
	public function mostrarErrorEmail(){
		if($this->errorEmail!==''){
			echo "<br><div class='alert alert-danger' role='alert'>".$this->errorEmail."</div>";
		}
	}
	/**************Fin de errores email*********************/
	
	
	
	/*************Errores clave1 y clave2*****************************/
	//Este código está enlazado con el input claveusuario1 y claveusuario2 de formusercreatevalidate.php y con el div de debajo suyo
	public function mostrarErrorClave1(){
		if($this->errorClave1!==''){
			echo "<br><div class='alert alert-danger' role='alert'>".$this->errorClave1."</div>";
		}
	}
	public function mostrarErrorClave2(){
		if($this->errorClave2!==''){
			echo "<br><div class='alert alert-danger' role='alert'>".$this->errorClave2."</div>";
		}
	}
	/**************Fin de errores clave1 y clave2*********************/
	
	
	
	
	public function registroValido(){
		if($this->errorNombre==='' && $this->errorEmail==='' && $this->errorClave1==='' && $this->errorClave2===''){
			return true;
		}
		else{
			return false;
		}
	}
}

?>