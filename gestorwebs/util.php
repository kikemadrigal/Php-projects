	<?php
	function cortarCadena($cadena){
		//substr($cadena, corta inicio, corta final)
		//strlen: devuelve la longitud de la cadena
		$longitud = 20;
		if($cadena == null) return ' ';
		
		$stringDisplay = substr($cadena, 0, $longitud);
		if (strlen($cadena) > $longitud)
        	$stringDisplay .= ' ...';
		return $stringDisplay;
	}
	function formatearCadena($cadena){
		//$arrayDeAsABuscar=array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä');
        //$arrayDeAsSustituidas('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A');
		$cadena=html_entity_decode($cadena);
		$cadena= str_replace(" ", "&nbsp;", $cadena);
		return $cadena;
	}
	function quitarEspaciosEnBlancoPrincipioYFinal($cadena){
		$cadenaLimpia=trim($cadena);
		//$cadenaLimpia=urlencode($cadenaLimpia);
		return $cadenaLimpia;
		
	}
	function recorrerEmoticonos($path){
		if(!isset($_GET['path'])){
			$path="imagenes/emoticonos/smiley/";
		}else{
			$path=$_GET['path'];
		}
		//echo $path;
		//abrimos el directorio
		$dir = opendir($path);
		//echo "<p>La ruta es: ".$path."</p>";
		//Mostramos las informaciones
		while ($elemento = readdir($dir))
		{ 
			if ($elemento=="." || $elemento=="..") {
					
			}else if(is_dir($elemento))//verificamos si es o no un directorio
			{
				echo "<h1>Hay una carpeta</h1>";
				$directorios[]=strtolower($elemento);
			}else{
				$archivos[]=strtolower($elemento);
			}
		}
			
			
		
		//Cerramos el directorio
		closedir($dir); 
		sort($archivos);  
		// (y mueves el puntero interno del array al principio ..) 
		reset($archivos);  

		// Lees tu array de $archivos 

		foreach ($archivos as $archivo){ 
			echo "<img src='/".$path.$archivo."' width='30' height='30' onclick='enviaremoticono(this.src)'></img>";
		} 
		foreach ($directorios as $carpeta){ 
			//echo "<a href=index.php?smiley=".$path.$carpeta."><img src=".$path.$archivo."></img>".$carpeta."</a><br />";
		} 
	}//Final de la funcion recorrer emoticonos


	function url_exists($url)
	{
		$file_headers = @get_headers($url);
		if(strpos($file_headers[0],"200 OK")==false)
		{
			/*if(strpos($file_headers[0],"301 Moved")==true){
				$iframe=substr($file_headers[4], 10, strlen($file_headers[4]));
				//echo "Web movida a <a href='".$iframe."' target='_blank'>".$iframe."</a>";
				return false;
			}*/
			echo $file_headers[0];
			//print_r($file_headers);
			$exists = false;
			return false;
		}
		else
		{
			$exists = true;
			return true;
		}
	}