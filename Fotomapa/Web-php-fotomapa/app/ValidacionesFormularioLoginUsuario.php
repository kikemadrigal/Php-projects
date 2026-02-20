<?php
require_once('RepositorioUsuario.php');
class ValidacionesFormularioLoginUsuario{
	private $nombre;
	private $clave;
	private $errorNombre;
	private $errorClave;

	function __construct($conexion,$nombre,$clave){
		$this->nombre="";
		$this->clave=$clave;
		$this->errorNombre=$this->validarNombre($conexion,$nombre);
		$this->errorClave=$this->validarClave($conexion, $nombre, $clave);
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
		if(!RepositorioUsuario::comprobarSiExisteNombre($conexion, $nombre)){
			return "Usuario no encontrado";
		}
		return "";
	}
	
	private function validarClave($conexion, $nombre, $clave){
		if (!$this->varibleVacia($clave)){
			return "Debes de escribir una contraseña.";
		}
		$usuario=RepositorioUsuario::obtener_usuario_por_nombre($conexion, $nombre);
		$claveVerficada=password_verify($clave,$usuario->getClave());
		if(!$claveVerficada){
			return "la clave es incorrecta.";
		}
		return "";
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getClave(){
		return $this->clave;
	}
	public function getErrorNombre(){
		return $this->errorNombre;
	}
	public function getErrorClave(){
		return $this->errorClave;
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
	
	
	
	
	
	/*************Errores clave1*****************************/
	//Este código está enlazado con el input claveusuario1 y claveusuario2 de formusercreatevalidate.php y con el div de debajo suyo
	public function mostrarErrorClave(){
		if($this->errorClave!==''){
			echo "<br><div class='alert alert-danger' role='alert'>".$this->errorClave."</div>";
		}
	}
	/**************Fin de errores clave*******************/
	
	
	
	
	public function registroValido(){
		if($this->errorNombre==='' && $this->errorClave==='' ){
			return true;
		}
		else{
			return false;
		}
	}
}

?>