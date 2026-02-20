<?php
/*************
	database
**************/
define('SERVER', 'mirar-en-pc');
define('DATABASE', 'mirar-en-pc');
define('USER', 'mirar-en-pc' );
define('PASSWORD','mirar-en-pc');





/*************
	Rutas
**************/



define('RUTA_SERVER', 'https://www.fotomapa.es');
define('RUTA_SERVER_HTTPS', 'https://www.fotomapa.es');
define('RUTA_HOME', RUTA_SERVER."/home");
define('APP_NAME', "Fotomapa.es");

/************Recursos************************/
define('RUTA_CSS',RUTA_SERVER.'/views/layouts/css/');
define('RUTA_CSS_HTTPS',RUTA_SERVER_HTTPS.'/views/layouts/css/');
define('RUTA_JS',RUTA_SERVER.'/views/layouts/js/');
define('RUTA_LIB',RUTA_SERVER.'/views/layouts/lib/');
define('RUTA_IMAGENES_WEB',RUTA_SERVER.'/resources/images');
/********Fin de recursos********************/


/***********Documentos**********************/
/*define('RUTA_DOCUMENTO_INICIO','views/layouts/document-start.inc.php');
define('RUTA_DOCUMENTO_FINAL','views/layouts/document-end.inc.php');
define('RUTA_BARRA_DE_NAVEGACION','views/layouts/navbar.inc.php');
define('RUTA_MENSAJE_DE_ERROR','views/layouts/error-message.inc.php');
define('RUTA_CONTROL_DE_SESION','app/ControlSesion.php');
define('RUTA_CONEXION_A_LA_BD','app/Conexion.php');
define('RUTA_REPOSITORIO_FOTOS','app/RepositorioFotos.php');
define('RUTA_CLASE_FOTO','app/Foto.php');*/
/*********Fin de documentos*****************/

/***********Download app*********************/
define('RUTA_DESCARGAS_APP', RUTA_SERVER.'/download');
/*****Fin de las rutas de mapa*************/



/*******Fotos****************************/
define('RUTA_HOME_FOTOS',RUTA_SERVER.'/home');
define('RUTA_VER_TODAS_LAS_FOTOS', RUTA_SERVER.'/photos/showall');
define('RUTA_VER_TODAS_LAS_FOTOS_DE_UN_USUARIO', RUTA_SERVER.'/photos/showalluser');
define('RUTA_VER_NO_VALIDADAS_DE_ANONIMOS', RUTA_SERVER.'/photos/show-not-validate-anonymous');
define('RUTA_VER_NO_VALIDADAS_DE_USUARIOS_REGISTRADOS', RUTA_SERVER.'/photos/show-not-validate-register-users');
define('RUTA_CARUSEL', RUTA_SERVER.'/carrusel');
define('RUTA_VER_FOTO', RUTA_SERVER.'/photos/show');
define('RUTA_CREAR_FOTO', RUTA_SERVER.'/photos/create');
define('RUTA_EDITAR_FOTO', RUTA_SERVER.'/photos/edit');
define('RUTA_VALIDAR_FOTO', RUTA_SERVER.'/photos/validate-photo');
define('RUTA_BORRAR_FOTO', RUTA_SERVER.'/photos/delete');
define('RUTA_FOTO_PANTALLA_COMPLETA', RUTA_SERVER.'/photos/fullscreenimage');

/*********Fin de fotos*******************/

/***********Mapa***************************/
define('RUTA_MAPA', RUTA_SERVER.'/map');
define('RUTA_MAPA_USUARIO', RUTA_SERVER.'/mapuser');
/*****Fin de las rutas de mapa*************/

/*********Users***********************/
define('RUTA_REGISTRO', RUTA_SERVER.'/user/create');
define('RUTA_REGISTRO_CORRECTO', RUTA_SERVER.'/user/create-ok');
define('RUTA_LOGIN', RUTA_SERVER.'/user/login');
define('RUTA_LOGOUT',RUTA_SERVER.'/user/logout');
define('RUTA_OLVIDO_CLAVE', RUTA_SERVER.'/user/forgetpassword');
define('RUTA_OLVIDO_CLAVE_DOS', RUTA_SERVER.'/user/loginresetpassword');
/**********Fin de users*****************/


/***************CAPTCHA*******************/
define('CLAVE_CAPTCHA','6LeXZUIUAAAAAPYwFA8IisInsxWolm2WUCkmup6o');
/******FIN CLAVE CAPTCHA*******************/


/****************GESTOR**********************/
define('RUTA_GESTOR', RUTA_SERVER.'/gestor');
define('RUTA_GESTOR_FOTOS_USUARIO', RUTA_GESTOR.'/fotosUser');
define('RUTA_GESTOR_COMENTARIOS_USUARIO', RUTA_GESTOR.'/comentariosUser');
define('RUTA_GESTOR_FAVORITOS_USUARIO', RUTA_GESTOR.'/favoritosUser');
define('RUTA_GESTOR_GENERICO_ADM', RUTA_GESTOR.'/genericoAdm');
define('RUTA_GESTOR_FOTOS_ADM', RUTA_GESTOR.'/fotosAdm');
define('RUTA_GESTOR_FOTOS_VER_TODAS_ADM', RUTA_GESTOR.'/admShowAll');
define('RUTA_GESTOR_FOTOS_EDITAR_ADM', RUTA_GESTOR.'/admEdit');
define('RUTA_GESTOR_FOTOS_BORRAR_ADM', RUTA_GESTOR.'/admDelete');
define('RUTA_GESTOR_USUARIOS_ADM', RUTA_GESTOR.'/userAdm');
define('RUTA_GESTOR_COMENTARIOS_ADM', RUTA_GESTOR.'/comentariosAdm');
define('RUTA_GESTOR_FAVORITOS_ADM', RUTA_GESTOR.'/favoritosAdm');
/*******FIN DE GESTOR**************************/



/***********Otros***************************/
define('RUTA_ANALYTICS', RUTA_SERVER.'/analitycs');
define('RUTA_CONTACTA', RUTA_SERVER.'/contact');
define('RUTA_CHAT', RUTA_SERVER.'/chat');
define('RUTA_INFO', RUTA_SERVER.'/info');
/*****Fin de las rutas de mapa*************/

?>