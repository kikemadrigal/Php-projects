
/**********Las validaciones tienen que hacerse en el lado del servior "backend*******************/
/**********Por eso los manejadores de eventos están desactivados*********************************/

function comprobarNombreUsuario(){
	var nombre=$('#nombreusuario').val();
	var repuestaDelServidor=document.getElementById('respuestaComprobarNombreUsuario');
	var respuesta="";
	$.ajax({
		type: 'POST',
		url:"model/userDB.php",
		data: 'accion=comprobarSiExisteUsuarioYaRegistrado&usuario='+nombre
	}).done(function (info){
		//console.log(info);
		//$('#respuestaComprobarNombreUsuario').html(info);
		if(info==1){
			$('#respuestaComprobarNombreUsuario').fadeIn();
			$('#respuestaComprobarNombreUsuario').html("El usuario ya existe");
			$('#buttonEnviarFormuarioCreateUser').prop("disabled",true);
		}else{
			if(nombre=='' || nombre.length==0){
				$('#respuestaComprobarNombreUsuario').fadeIn();
				$('#respuestaComprobarNombreUsuario').html("Debes de introducir un nombre de usuario");
				$('#buttonEnviarFormuarioCreateUser').prop("disabled",true);
			}else{
				if(nombre.length>15){
					$('#respuestaComprobarNombreUsuario').fadeIn();
					$('#respuestaComprobarNombreUsuario').html("El nombre no puede ser mayor de 15 carácteres.");
					$('#buttonEnviarFormuarioCreateUser').prop("disabled",true);
				}else{
					$('#buttonEnviarFormuarioCreateUser').prop("disabled",false);
					$('#respuestaComprobarNombreUsuario').fadeOut();
				}
			}
		}
	});
}

function comprobarCorreoUsuario(){
	var correo=$('#correousuario').val();
	console.log("entra en validar correo");
	var repuestaDelServidor=document.getElementById('respuestaComprobarCorreoUsuario');
	var respuesta="";
	$.ajax({
		type: 'POST',
		url:"model/userDB.php",
		data: 'accion=comprobarSiExisteCorreoYaRegistrado&correo='+correo
	}).done(function (info){
		//console.log(info);
		//$('#respuestaComprobarCorreoUsuario').html(info);
		if(info==1){
			$('#respuestaComprobarCorreoUsuario').html("El correo ya existe");
			$('#buttonEnviarFormuarioCreateUser').prop("disabled",true);
		}else{
			//document.getElementById('buttonEnviarFormuarioCreateUser').removeAttribute("disabled");
			 $('#buttonEnviarFormuarioCreateUser').prop("disabled",false);
			$('#respuestaComprobarCorreoUsuario').fadeOut();
		}
	});
}


 function validarClavesIguales(){
	 var permitidoSubmit=false;
	 var clave1=document.getElementById("claveusuario1").value;
	 var clave2=document.getElementById("claveusuario2").value;
	 if(clave1!='' && clave2!=''){
		 if (clave1 != clave2){ 
			$('#respuestaComprobarClavesIguales').fadeIn();
			$('#respuestaComprobarClavesIguales').html("Las claves no coinciden");
			//permitidoSubmit=false;
			$('#buttonEnviarFormularioCreateUser').prop("disabled",true);
		 }else{
			//permitidoSubmit=true;
			$('#buttonEnviarFormularioCreateUser').prop("disabled",false);
			$('#respuestaComprobarClavesIguales').fadeOut();
		 }
	 }
 }



//document.getElementById('nombreusuario').addEventListener("change",comprobarNombreUsuario,false);
//document.getElementById('nombreusuario').addEventListener("change",comprobarCorreoUsuario,false);
//document.getElementById('claveusuario1').addEventListener("change",validarClavesIguales,false);
//document.getElementById('claveusuario2').addEventListener("change",validarClavesIguales,false);
	
