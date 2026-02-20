<?php
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
//$userValidador = new ValidacionesFormularioNuevoUsuario($conexion,$_POST[ 'nombreusuario' ], $_POST[ 'correousuario' ], $_POST[ 'claveusuario1' ], $_POST[ 'claveusuario2' ] );
	//if($userValidador->registroValido()){
		//$usuario=new Usuario('',$userValidador->getNombre(),password_hash($userValidador->getClave1(), PASSWORD_DEFAULT),'usuario', $userValidador->getEmail(), 'nada','nada','nada','0','0',date('Y-m-d'),$userValidador->getClave1());
        $usuario=new Usuario('',$_POST[ 'nombreusuario' ],$_POST[ 'claveusuario1' ], $_POST[ 'correousuario' ], 'nada','nada','nada','0','0',date('Y-m-d'),$_POST[ 'claveusuario1' ]);
		
        $insertadoUsuario=RepositorioUsuario::stored($conexion,$usuario);
		//echo "<h1>----------------->".$insertadoUsuario."</h1>";
		//echo "<h1>----------------->".RUTA_REGISTRO_CORRECTO.'?nombre='.$usuario->getNombre()."</h1>";
		/*if($insertadoUsuario){
		
			$ruta=RUTA_REGISTRO_CORRECTO.'/'.$usuario->getNombre();
			echo "<script type='text/javascript'>location.href='$ruta';</script>";
			die();
		}else{
			echo "No se pudo crear el nuevo usuario";
        }*/
	}
    Conexion::cerrar_conexion();
    
?>