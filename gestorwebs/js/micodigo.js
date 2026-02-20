function ver(image){
document.getElementById('image').innerHTML = "<img src='"+image+"'>";
} 
 

 /*********Funciónd el administrador para introducit imágenes en el textArea********/
 function enviarTexto(texto){
	document.getElementById('descripcionWeb').value +=" <img src= ";
	document.getElementById('descripcionWeb').focus();
}
 function desabilitarComponenteinamgenWeb(){
 	var componente=document.getElementById('imagenWeb').disabled=true;
 	console.log(componente.value);
}
 
 
 function validarformularioactualizarusuarionuevo(){
	//alert('pasa or el princiapl ');
	var verificar=false;
	var formulario;
	var claveusuario="";
	var claveusuariodos="";
	 //claveusuario=document.formulariorepitecontrasena.claveusuario.value;
	formulario=document.getElementById('formulariorepitecontrasena');
	inputClaveUsuario = document.getElementById('claveusuario');
	claveusuario = document.getElementById('claveusuario').value;
	claveusuariodos = document.getElementById('claveusuariodos').value;
	// claveusuariodos=document.formulariorepitecontrasena.claveusuariodos.value;
	//alert('pasa por validar: clave 1: '+claveusuario+', clave 2: '+claveusuario2);
	//return false;
	//alert('clave: '+claveusuario+', clave 2: '+claveusuario2);
	if( claveusuario != claveusuariodos ) {
  		
	//alert('La contrasenas son incorrectas');
		document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;as son incorrectas</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='00000' || claveusuario=='0000000'  || claveusuario=='00000000'  || claveusuario=='00000000' || claveusuario=='00000000'  || claveusuario=='000000000'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='11111' || claveusuario=='1111111'  || claveusuario=='11111111'  || claveusuario=='11111111' || claveusuario=='11111111'  || claveusuario=='111111111'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='22222' || claveusuario=='2222222'  || claveusuario=='22222222'  || claveusuario=='22222222' || claveusuario=='22222222'  || claveusuario=='222222222'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='33333' || claveusuario=='3333333'  || claveusuario=='33333333'  || claveusuario=='33333333' || claveusuario=='33333333'  || claveusuario=='333333333'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='44444' || claveusuario=='4444444'  || claveusuario=='44444444'  || claveusuario=='44444444' || claveusuario=='44444444'  || claveusuario=='444444444'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='55555' || claveusuario=='5555555'  || claveusuario=='55555555'  || claveusuario=='55555555' || claveusuario=='55555555'  || claveusuario=='555555555'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='66666' || claveusuario=='6666666'  || claveusuario=='66666666'  || claveusuario=='66666666' || claveusuario=='66666666'  || claveusuario=='666666666'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='77777' || claveusuario=='7777777'  || claveusuario=='77777777'  || claveusuario=='77777777' || claveusuario=='77777777'  || claveusuario=='777777777'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='88888' || claveusuario=='8888888'  || claveusuario=='88888888'  || claveusuario=='88888888' || claveusuario=='88888888'  || claveusuario=='888888888'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='99999' || claveusuario=='9999999'  || claveusuario=='99999999'  || claveusuario=='99999999' || claveusuario=='99999999'  || claveusuario=='999999999'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='99999' || claveusuario=='9999999'  || claveusuario=='99999999'  || claveusuario=='99999999' || claveusuario=='99999999'  || claveusuario=='999999999'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else if(claveusuario=='12345' || claveusuario=='123456'  || claveusuario=='1234567'  || claveusuario=='12345678' || claveusuario=='123456789'  || claveusuario=='0123456'){    	document.getElementById("textoClave").value="<h1><center>Las contrase&ntilde;a es demasiado f&aacute;cil</center></h1>";
		verificar= false;
		inputClaveUsuario.focus();
	}else{
		verificar= true;
	}
	 if(verificar==true){
		//alert('verficar true, dice que los campos son iguales');
		 formulario.submit('gestionarusuarios.php');
	 }else{
		// alert('verficar false no son iguales');
	 }
 }
 
 
 function validar(){
	// alert("a entrado");
	 var clave=document.getElementById("claveusuario").value;
	 var claveDos=document.getElementById("claveusuariodos").value;
	 if (clave != claveDos){ 
		//alert("no son iguales");
      	document.getElementById("textoClave").innerHTML="<h1><center>Las contrase&ntilde;as no coinciden</center></h1>";
      	document.formulariorepitecontrasena.claveusuario.focus() 
		
      	return false; 
   	} else{
	
		return true;
	}
	 
	 
	 
	 
 }
 
 
  function validarImagen(){
	// alert("a entrado");
	 var imagen=document.getElementById("file").value;
	
	 if (imagen.length==1){ 
		//alert("no son iguales");
      	document.getElementById("mensajeImagen").innerHTML="<h1><center>Tienes que elegir una imagen antes de enviar</center></h1>";
      	document.getElementById("file").focus();
		
      	return false; 
   	} else{
	
		return true;
	}
	 
	 
	 
	 
 }
 
 
 
function validarFormularioActualizarUsuario(){
	var clave=document.getElementById("claveusuarioactualizar").value;
	 var claveDos=document.getElementById("claveusuariodosactualizar").value;
	 if (clave != claveDos){ 
		//alert("no son iguales");
      	document.getElementById("textoClaveActualizar").innerHTML="<h1><center>Las contrase&ntilde;as no coinciden</center></h1>";
      	document.formulariorepitecontrasenaactualizar.claveusuarioactualizar.focus() 
		
      	return false; 
   	} else{
	
		return true;
	}
	
	
	
}
 
 




/********************Emoticonos*******************************************/
function nuevoAjax(){
	var xmlhttp=false;
 	try {
 		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 	} catch (e) {
 		try {
 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 		} catch (E) {
 			xmlhttp = false;
 		}
  	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function cargarCaras(){
	var subcapaemo=document.getElementById('subcapaemoticonos');
	ajax8=nuevoAjax();
	//alert('has hecho clik');
	ajax8.open("GET", "/emoticonos.php",true);
	ajax8.onreadystatechange=function() {
		if (ajax8.readyState==4) {
			subcapaemo.innerHTML = ajax8.responseText;
		}
	}
	ajax8.send(null)
	
}
function cargarPerros(){
	var subcapaemo=document.getElementById('subcapaemoticonos');
	path="imagenes/emoticonos/naturaleza/";
	ajax7=nuevoAjax();
	ajax7.open("GET", "/emoticonos.php?path="+path,true);
	//alert(path);
	ajax7.onreadystatechange=function() {
		if (ajax7.readyState==4) {
			subcapaemo.innerHTML = ajax7.responseText;
		}
	}
	ajax7.send(null)
}
function cargarLugares(){
	var subcapaemo=document.getElementById('subcapaemoticonos');
	path="imagenes/emoticonos/lugares/";
	ajax7=nuevoAjax();
	ajax7.open("GET", "/emoticonos.php?path="+path,true);
	//alert(path);
	ajax7.onreadystatechange=function() {
		if (ajax7.readyState==4) {
			subcapaemo.innerHTML = ajax7.responseText;
		}
	}
	ajax7.send(null)
}
function cargarObjetos(){
	var subcapaemo=document.getElementById('subcapaemoticonos');
	path="imagenes/emoticonos/objetos/";
	ajax7=nuevoAjax();
	ajax7.open("GET", "/emoticonos.php?path="+path,true);
	//alert(path);
	ajax7.onreadystatechange=function() {
		if (ajax7.readyState==4) {
			subcapaemo.innerHTML = ajax7.responseText;
		}
	}
	ajax7.send(null)
}
function cargarSimbolos(){
	var subcapaemo=document.getElementById('subcapaemoticonos');
	path="imagenes/emoticonos/simbolos/";
	ajax7=nuevoAjax();
	ajax7.open("GET", "/emoticonos.php?path="+path,true);
	//alert(path);
	ajax7.onreadystatechange=function() {
		if (ajax7.readyState==4) {
			subcapaemo.innerHTML = ajax7.responseText;
		}
	}
	ajax7.send(null)
}
function enviaremoticono(fotoNueva){
	var posicionBarra=fotoNueva.lastIndexOf('/');
	var ultimaLetra=fotoNueva.length;
	var substring=fotoNueva.substring(posicionBarra+1,ultimaLetra);
	document.getElementById('textoComentarioCategoria').value +=" [["+substring+"]] ";
	document.getElementById('textoComentarioCategoria').focus();
	
}
/*************Fin de cargar emoticonos****************************/
//Con esta función muestros los grupos que h eocultado en la página
//gestionarCategoriasagrupadas.php con <div id='oculto' style='display:none;'> 

		
	


/****************************************************JQUERy***********************************************************************/





$('document').ready(function() {
	
  	$('#mostrarOculatr').click(function(env) {
    
		$('#menuausuarioswebs').toggle();
		});
	  
  	$('.botonemoticono').click(function(env) {
  		//alert("has hecho clik");
		$('#capaemoticonos').toggle();
		/*$('#capaemoticonos').click(function({
			console.log('Has hecho clik');
		}));*/
	});
  	$('#botonemoticonosperro').click(function(env){
		cargarPerros();	
	});
	$('#botonemoticonossmiley').click(function(env){
		cargarCaras();	
	});
	$('#botonemoticonoslugar').click(function(env){
		cargarLugares();	
	});
	$('#botonemoticonosobjetos').click(function(env){
		cargarObjetos();	
	});
	$('#botonemoticonossimbolos').click(function(env){
		cargarSimbolos();	
	});


  
  
});