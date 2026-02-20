<?php
require_once('RepositorioUsuario.php');
class ValidacionesFormularioReseteoClave{
	private $clave1;
	private $clave2;
	private $errorClave1;
	private $errorClave2;

	function __construct($conexion,$clave1,$clave2){
		$this->clave1=$clave1;
		$this->clave2=$clave2;
		$this->errorClave1=$this->validarClave1($conexion,$clave1);
		$this->errorClave2=$this->validarClave2($conexion,$clave1, $clave2);
	}
	private function varibleVacia($variable){
		if(isset($variable) && !empty($variable)){
			return true;
		}
		else{
			return false;
		}
	}
	private function validarClave1($conexion,$clave1){
		if (!$this->varibleVacia($clave1)){
			return "Debes de escribir una contraseña en la clave 1";
		}else{
			$this->clave1=$clave1;
		}
		if(strlen($clave1)<4){
			return  "La clave debe tener más de 4 carácteres.";
		}
		
		if(strlen($clave1)>15){
			return "La clave no puede ser mayor de 15 caracteres.";
		}
		return "";
	}
	
	private function validarClave2($conexion, $clave1, $clave2){
		if (!$this->varibleVacia($clave2)){
			return "Debes de escribir una contraseña en la clave 2.";
		}
		if($clave1 !== $clave2){
			return "Las contraseñas no coinciden";
		}
		return "";
	}
	
	/*public function getClave1(){
		return $this->clave1;
	}
	
	public function getClave2(){
		return $this->clave2;
	}
	public function getErrorClave1(){
		return $this->errorClave1;
	}
	public function getErrorClave2(){
		return $this->errorClave2;
	}*/

	
	
	/*************Errores ****************************/
	//Este código está enlazado con el input nombreusuario de formusercreatevalidate.php y con el div de debajo suyo
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
	/**************Fin de errores*********************/
	
	
	
	
	

	
	
	
	public function registroValido(){
		if($this->errorClave1==='' && $this->errorClave2==='' ){
			return true;
		}
		else{
			return false;
		}
	}
}

?>