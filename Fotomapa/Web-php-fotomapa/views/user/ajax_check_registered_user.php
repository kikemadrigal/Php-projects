<?php
    session_start();
	header("access-control-allow-origin: *");


	require_once( "../../app/ControlSesion.php" );

    //echo "pasa por check";
	if ( ControlSesion::comprobar_sesion_iniciada() ) {
		echo true;
	} else {
		echo false;
	}

	
	
	
	




?>