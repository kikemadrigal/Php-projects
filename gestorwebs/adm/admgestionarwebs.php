<?php
session_start();
if ($_SESSION["claveusuario"] !="1c558dfd6f4148767d40386fa7b59c18e3b8627e") {
   header("Location: ../noautorizdo.php");
   exit();
}
	include("admdibujarhtml.php");
	require('../Mysql.php');
	require('../Web.php');
	dibujarhtmladministrador();
	
	
	if (isset($_GET['mensaje'])) echo "<br /><span style='color:red'>".$_GET['mensaje']."</span>";
	
	
	
	
	
	
	/*function convertirObjetoParaPasarPorURL(Web $objeto){
		//$argumento = urlencode(serialize($objeto));
		$argumento = serialize($objeto);
		return $argumento;	
	}
	function recuperarObjetoPasadoPorURL(Web $objeto){
		//$argumento = unserialize(urldecode($objeto));
		$argumento = unserialize($objeto);
		return $argumento;
	}*/
	function cortarCadena($cadena){
		//Strip_tags: retira las etiquetas HTML y PHP de un String
		//substr($cadena, corta inicio, corta final)
		//strlen: devuelve la longitud de la cadena
		$longitud = 20;
		$stringDisplay = substr(strip_tags($cadena), 0, $longitud);
		if (strlen(strip_tags($cadena)) > $longitud)
        	$stringDisplay .= ' ...';
		return $stringDisplay;
	}
	/*function formatearCadena($cadena){
		//$arrayDeAsABuscar=array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä');
        //$arrayDeAsSustituidas('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A');
		$cadena=html_entity_decode($cadena);
		$cadena= str_replace(" ", "&nbsp;", $cadena);
		return $cadena;
	}*/
	/*function obtenerNombreEmpresa($idEmpresa){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM empresas WHERE idEmpresa='.$idEmpresa.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			return $linea['nombreEmpresa'];
		}
		$basededatos->desconectar();
	}*/
	function obtenerNombreWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM webs WHERE idWeb='.$idWeb.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombreweb'];
		}
		$basededatos->desconectar();
	}
	function obtenerNombreCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias WHERE idcategoria='".$idCategoria."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombrecategoria'];
		}
		$basededatos->desconectar();
	}
	
	function recorrerCategoriasConSelect($nivelCategoria, $categoriaeshijade){
		$nivelCategoria++;
		
		$basededatos1= new Mysql();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias WHERE nivelcategoria='".$nivelCategoria."' && idpadrecategoria='".$categoriaeshijade."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=1;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1)) 
		{
			echo "<option value='".$linea1['idcategoria']."' >".$espacios.$linea1['nombrecategoria']."</option>";
			if ($linea1['categoriaeshijade'] != null){
				 recorrerCategoriasConSelect($nivelCategoria, $linea1[idcategoria] );			
			}
		}
		$basededatos1->desconectar();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*******************************************Pepi****************************************************************************************/
	
	function dameUnaCategoria(){ //accion 40
		echo "<h1><center>1. Crear o elegir categoria de la web</center></h1>";
		echo"<p>Selecciona una Categoria:</p>";
		echo "<form method=get action='admgestionarwebs.php' class='form-horizontal'>";
		dibujarLayoutCategorias();
		echo "<input type=hidden name=accion value=41></input>";
		echo "<input type='submit' value='Seleccionar categoría' class='btn btn-primary' ></input> ";
		echo "<br /><br /><br /><a href='admgestionarwebs.php?accion=44' class='btn btn-primary'>Crear nueva categoria</a>";
	}
	
		
	
	function dameUnaFoto(){
		echo "<h1><center>2. Subir la imagen de la web al servidor de china</center></h1>";
		?>
		<br />
		<form method=post action='admgestionarwebs.php' class='form-horizontal' enctype='multipart/form-data' onsubmit='return validarImagen()'>
			<input type='file' name='file' id='file' onChange='ver(form.file.value)' />
            <input type=hidden name='categoriaweb' value='<?php echo $_GET['categoriaweb'];?>'></input>
            <br />
            <input type=hidden name=accion value=42></input>
            <input type='submit' value='Subir imagen!' class='btn btn-primary' ></input> 
            <div id='mensajeImagen'></div>
			
		</form> 
        <br />
        <br />
        <form method=post action='admgestionarwebs.php' class='form-horizontal' enctype='multipart/form-data'>
			<input type=hidden name='categoriaweb' value='<?php echo $_GET['categoriaweb'];?>'></input>
          	<input type=hidden name='imagenWeb' value='sinimagen1.jpg'></input>
            <input type=hidden name=accion value=42></input>
			<input type='submit' value='Dejar sin imagen' class='btn btn-primary' ></input> 
		</form> 
        <?php
		
	}
	
	function aplicarInsercionImagen(){
				
					if($_POST['imagenWeb']!="sinimagen1.jpg"){
						//echo "entra porqui";
						$nombre_archivo = $_FILES['file']['name']; 
						$tipo_archivo = $_FILES['file']['type']; 
						$nombreImagen=$nombre_archivo;
						
						//echo "<br />El archivo pasado es: <br />".$nombreImagen;
						$tamano_archivo = $_FILES['file']['size']; 
						$bd= new Mysql();
						$bd->conectar_mysql();
						if (!(strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png") || $tamano_archivo > 900000)) 
						{
							$nombreImagen="sinimagen.png";
							$bd->ejecutar_sql($sql);
							if(!$bd)
							{
								echo "Error al insertar.";	
							}
							echo "La foto no tiene el formato o el tam&ntilde;o correcto, solo se aceptan, jpg o png menores de 90Mb.<br />";
						}else
						{ 
								move_uploaded_file($_FILES['file']['tmp_name'], "../imagenes/webs/".$nombreImagen);
								$sql="INSERT INTO imagenes VALUES ( '', '$nombreImagen', '0') ";
								$bd->ejecutar_sql($sql);
								if(!$bd)
								{
									echo "Error al insertar.";	
								}
								$mensaje="Imagen ".$nombreImagen." subida!!!.";
								echo "<script type='text/javascript'>location.href='admgestionarwebs.php?accion=43&imagenWeb=$nombreImagen&categoriaweb=$_POST[categoriaweb]'</script>";
   						} 					
						$bd->desconectar();	
					}else{ //si $_POST['imagenWeb']="sinimagen1.jpg"
						echo "<script type='text/javascript'>location.href='admgestionarwebs.php?accion=43&imagenWeb=$_POST[imagenWeb]&categoriaweb=$_POST[categoriaweb]'</script>";
					}
				
	}
	function aplicarInsercionImagenSinRedirigir(){
						$nombre_archivo = $_FILES['archivo']['name']; 
						$tipo_archivo = $_FILES['archivo']['type']; 
						$nombreImagen=$nombre_archivo;
						//echo "<br />El archivo pasado es: <br />".$nombreImagen;
						$tamano_archivo = $_FILES['archivo']['size']; 
						$bd= new Mysql();
						$bd->conectar_mysql();
						if (!(strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png") || $tamano_archivo > 900000)) 
						{
							$nombreImagen="sinimagen.png";
							$bd->ejecutar_sql($sql);
							if(!$bd)
							{
								echo "Error al insertar.";	
							}
							echo "La foto no tiene el formato o el tam&ntilde;o correcto, solo se aceptan, jpg o png menores de 90Mb.<br />";
						}else
						{ 
								move_uploaded_file($_FILES['archivo']['tmp_name'], "../imagenes/webs/".$nombreImagen);
								$sql="INSERT INTO imagenes VALUES ( '', '$nombreImagen', '0') ";
								$bd->ejecutar_sql($sql);
								if(!$bd)
								{
									echo "Error al insertar.";	
								}
								$mensaje="Imagen ".$nombreImagen." insertada.";
   						} 					
						$bd->desconectar();	
	}
	
	
	
	function rellenarRestoCamposWeb(){
	
		?>
		<br />
       <h1><center>3. Dame el resto de los datos que faltan para la web</center></h1>
        <br />
		<form method=post action='admgestionarwebs.php' class='form-horizontal'>
		
			<div class='form-group' >
		             <label for='nombreWeb' class='control-label col-md-2'>URL o direccion web:</label>
		            <div class='col-md-10'>
        						<input type='text' class='form-control' name='nombreWeb' id='nombreWeb' size=80 title='Se necesita un nombre' required >
                    </div>
		    </div> 
            <div class='form-group' >
		             <label for='tituloWeb' class='control-label col-md-2'>Nombre de la web:</label>
		            <div class='col-md-10'>
        						<input type='text' class='form-control' name='tituloWeb' id='tituloWeb' size=80 title='Se necesita un título' required >
                    </div>
		    </div> 
		    <div class='form-group' >
		               <label for='descripcionWeb' class='control-label col-md-2'>Descripcion:</label> 
		                <div class='col-md-10'>
		                	<a href='#' value='abierto' onclick='enviarTexto(this.value)'>Abierto</a>&nbsp;&nbsp;&nbsp;&nbsp;
		                	<a href='#' value='cerrado' onclick='enviarTexto(this.value)'>Cerrado</a>&nbsp;&nbsp;&nbsp;&nbsp;
		                	<!--<form  action='#' method='POST' enctype='multipart/form-data'>-->
			                	<input type='file' id='fotoadministrador' name='fotoadministrador'>&nbsp;&nbsp;&nbsp;&nbsp;
			                	<input type='button' value='subir imagen' onclick='enviarFotoAdministrador()'>
			                <!--</form>-->
                        	<textarea class='form-control' name='descripcionWeb' id='descripcionWeb' rows=10 cols=60></textarea>
                        </div>
		    </div>
		    <div class='form-group' > 
		               <label for='tagsWeb' class='control-label col-md-2'>Tags:</label> 
		               <div class='col-md-10'>
                       		<input type='text' class='form-control' name='tagsWeb' id='tagsWeb' size=80>
                       </div>
		    </div> 
		    <div class='form-group' >
		               <label for='numeroVotosWeb' class='control-label col-md-2'>Número de votos: </label> 
		               <div class='col-md-10'>
                        	<input type='number' class='form-control' name='numeroVotosWeb' id='numeroVotosWeb' title='De 1 a 10000' pattern='[0-9]{1,10000}' placeholder='Num. votos:' required />
                       </div>
		    </div> 
		    <div class='form-group' >  
		              <label for='mediaVotosWeb' class='control-label col-md-2'>Media: </label> 
		              <div class='col-md-10'>
                       		<input type='number' class='form-control' name='mediaVotosWeb' id='mediaVotosWeb' title='De 1 a 10' pattern='[0-9]{1,10}' placeholder='Media:' required />
                      </div>
		    </div> 
		 	<div class='form-group' > 
		 				 <label for='imagenWeb' class='control-label col-md-2'>Foto: </label>  
		 				 <div class='col-md-10' >
                         	<input type='text' class='form-control' name='imagenWeb' id='imagenWeb'  readonly='readonly'  size=80 value='<?php echo $_GET['imagenWeb'];?>' required="required"/>
                            </select>
                         </div> 
		 	</div> 
		    <div class='form-group' >
		             <label for='categoriaweb' class='control-label col-md-2'>Categoria: </label> 
		 			  <div class='col-md-10' >
                            	<?php
											echo" <input type='text' class='form-control' name='categoriaweb' readonly='readonly' value='".$_GET['categoriaweb']."' >";
											echo obtenerNombreCategoria($_GET['categoriaweb'])."</input>";
                               ?>
                      </div> 
             </div><!-- final del form-group del select idcategoria -->
            
             <input type=hidden name=accion value=12></input>  
               <div class='form-group' > 
                           <div class='col-md-10 col-md-offset-2' >
                                <input type='submit' value='Insertar web' class='btn btn-primary' ></input> 
                           </div>
                </div> 
            
              </form> 
            <?php	
	}
	


	
	function crearNuevaCategoria(){//acion 44
		
		echo"<p>Menu insertar nueva categoria</p>";
		echo"<form method=post action='admgestionarwebs.php' class='form-horizontal'>";
	
		echo" <div class='form-group' > ";
				echo"<label for='nombreCategoria' class='control-label'>Nombre categoria:</label>";
					echo" <div  > ";
						echo"<input type='text' class='form-control'  name='nombreCategoria'  title='El nombre debe de contener entre 4 y 50 letras o números' pattern='[a-zA-Z0-9\d_- áéíóúÁÉÍÓÚÑñ]{4,50}' placeholder='Nombre:'  required />";
					echo" </div> ";
					echo"<label for='tituloCategoria' class='control-label'>Titulo:</label>";
					echo" <div  > ";
						echo"<input type='text' class='form-control'  name='tituloCategoria'  id='tituloCategoria' title='El t&iacute;tulo debe de contener entre 4 y 5000 letras o números' pattern='[a-zA-Z0-9\d_- áéíóúÁÉÍÓÚÑñ]{4,5000}' placeholder='Nombre:'  required />";
					echo" </div> ";
		echo" </div>";
		echo" <div class='form-group' > ";
			echo "<label for='categoriaEsHijaDe' class='control-label '>Es hija de:</label>";
			echo" <div  > ";
				echo "<select name='categoriaEsHijaDe' class='form-control' required> ";
								//echo "<option value='Base' >Base</option>";
								$nivelCategoria=1;
								$basededatos= new mysql();
								$basededatos->conectar_mysql();
								$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
								$resultado=$basededatos->ejecutar_sql($consulta);
								while ($linea = mysqli_fetch_array($resultado)) 
								{
										echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
										recorrerCategoriasConSelect($nivelCategoria, $linea[idcategoria] );
								}
								$basededatos->desconectar();
						echo "</select>";
			echo" </div> ";
		echo" </div> ";
		echo" <div class='form-group' > ";
			echo "<div class='col-md-offset-2' >";
				echo "<input type=hidden name=accion value=45></input> ";
				echo"<input type=submit value='Insertar nueva categoria' class='btn btn-primary btn-large' ></input>";
			echo"    </div>";
		echo"    </div>";
		echo" </form>";
	}
	function obtenerNivelCategoria($idCategoria){
		$basededatos= new mysql();
		$basededatos->conectar_mysql();
		$consulta  ="SELECT nivelcategoria FROM categorias WHERE idcategoria='".$idCategoria."' LIMIT 1 ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$num_reg=mysqli_num_rows($resultado);
		if($num_reg==null){
			 echo "<br />No hubo resultados en nivel categorias<br />";
			 $nivelcategoria=null;
			 return $nivelcategoria;
		}
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nivelcategoria'];
		}
		$basededatos->desconectar();
	}
	
	
	function aplicarInsercionCategoria(){//accion 45
			$nivelCategoria=obtenerNivelCategoria($_POST[categoriaEsHijaDe]);
			$nivelCategoria++;
			$nombrePadre=obtenerNombreCategoria($_POST[categoriaEsHijaDe]);
			$bd2= new mysql();
			$bd2->conectar_mysql();
			$sql2="INSERT INTO categorias VALUES ( '', '$_POST[nombreCategoria]', '$_POST[tituloCategoria]','$nombrePadre', '$_POST[categoriaEsHijaDe]', '$nivelCategoria') ";
			$result=$bd2->ejecutar_sql($sql2);
			$idCategoriaInsertada=mysqli_insert_id();
			//$bd2->ejecutar_sql($sql2);
			
			$bd2->desconectar();
			$mensaje="Categoria ".$_POST[nombreCategoria]." nueva insertada.";
			echo "<script type='text/javascript'>location.href='admsgestionarwebs.php?accion=41&categoriaweb=$idCategoriaInsertada&mensaje=".$mensaje."';</script>";
		
	}
	/*****************************************************************fin pepi********************************************************************/
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	
	
	function dibujarLayoutCategorias(){
					echo "<select name='categoriaweb' class='form-control col-md-6' required> ";
									$nivelCategoria=1;
									$basededatos= new Mysql();
									$basededatos->conectar_mysql();
									$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
									$resultado=$basededatos->ejecutar_sql($consulta);
									while ($linea = mysqli_fetch_array($resultado)) 
									{
											echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
											recorrerCategoriasConSelect($nivelCategoria, $linea[idcategoria] );
									}
									$basededatos->desconectar();
				echo "</select>";
					
		}
		
		
	
	

	function dibujarLayoutCategoriasDos(){
			
				echo"<form method=post action='admgestionarwebs.php'>";
				echo "<select name='categoriaweb' class='form-control col-md-6' required> ";
								$nivelCategoria=1;
								$basededatos= new Mysql();
								$basededatos->conectar_mysql();
								$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
								$resultado=$basededatos->ejecutar_sql($consulta);
								while ($linea = mysqli_fetch_array($resultado)) 
								{
										echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
										recorrerCategoriasConSelect($nivelCategoria, $linea[idcategoria] );
								}
								$basededatos->desconectar();
						echo "</select>";
				echo"<input type=submit value='Buscar por categoría'  class='btn btn-default'></input>";
				echo "</form>";
			
	}

	function dibujarLayoutCategoriasMostrandoLaCategoriaAsignada($categoriaAsignada){
					
					echo "<select name='categoriaweb' class='form-control col-md-6' required> ";
							echo "<option value='".$categoriaAsignada."' style='background:yellow'>".obtenerNombreCategoria($categoriaAsignada)."</option>";
									$nivelCategoria=1;
									$basededatos= new Mysql();
									$basededatos->conectar_mysql();
									$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
									$resultado=$basededatos->ejecutar_sql($consulta);
									while ($linea = mysqli_fetch_array($resultado)) 
									{
											echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
											recorrerCategoriasConSelect($nivelCategoria, $linea['idcategoria'] );
									}
									$basededatos->desconectar();
				echo "</select>";
					
		}
	
	
	
	



	function dibujarWebs(){
		?>
        <div class='menuadministradorwebs'>
			<a href='admgestionarwebs.php?accion=1' class='btn btn-danger'>Crear nueva web</a><br/>
			<div class="dropup">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Ordenar
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                       <li><a href=admgestionarwebs.php?ordenar=nombreweb >Por nombre</a></li>
                       <li><a href=admgestionarwebs.php?ordenar=mediavotosweb >Por votos</a></li>
                       <li><a href=admgestionarwebs.php?ordenar=imagenweb >Por foto</a></li>
                        <li><a href=admgestionarwebs.php?ordenar=idweb c>Por ID</a></li>
                  </ul>
             </div>
             <form method=post action='admgestionarwebs.php'>
					<input type='text' class='form-control' name='tituloWeb' id='tituloWeb' size=80 title='Se necesita un nombre' placeholder='Escribe el nombre de la web a buscar aquí'  required >
					<!-- <input type=hidden name=accion value=23></input>  -->
					<input type='submit' value='Filtrar por nombre' class='btn btn-default' ></input> 
			</form>
               <?php
                  dibujarLayoutCategoriasDos();
               ?>
		 </div><!-- final del menu administrador web -->
         <?php
		$TAMANO_PAGINA = 10;
		if (isset($_GET["ordenar"])){
			$ordenar=$_GET["ordenar"];
		}else{
			$ordenar="idweb";
		}
		
		
		$pagina = $_GET["pagina"];
		
		if (!$pagina) {
			$inicio = 0;
			$pagina=1;
		}
		else {
			$inicio = ($pagina - 1) * $TAMANO_PAGINA;
		} 
					
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		if(isset($_POST['categoriaweb'])){
			$consulta  = "SELECT * FROM webs WHERE categoriaweb=".$_POST[categoriaweb]." ORDER BY ".$ordenar." DESC limit " . $inicio . "," . $TAMANO_PAGINA."";
			$consulta2  = "SELECT * FROM webs WHERE categoriaweb=".$_POST[categoriaweb]." ORDER BY ".$ordenar." DESC ";
		}else if(isset($_POST['tituloWeb'])){
			$consulta  = "SELECT * FROM webs WHERE tituloweb LIKE '%".$_POST[tituloWeb]."%' ORDER BY ".$ordenar." DESC limit " . $inicio . "," .$TAMANO_PAGINA."";
			$consulta2  = "SELECT * FROM webs WHERE tituloweb LIKE '%".$_POST[tituloWeb]."%' ORDER BY ".$ordenar." DESC";
		}else{
			$consulta  = "SELECT * FROM webs ORDER BY ".$ordenar." DESC limit " . $inicio . "," .$TAMANO_PAGINA."";
			$consulta2  = "SELECT * FROM webs ORDER BY ".$ordenar." DESC ";
		}
		
		$resultado=$basededatos->ejecutar_sql($consulta);
		$resultado2=$basededatos->ejecutar_sql($consulta2);
		$total_registros=mysqli_num_rows($resultado);
		if($total_registros==FALSE){
			echo" <p>No se obtuvo ning&uacute;n resultado.</p>"	;
		}else{
				$total_registros_sin_limitacion=mysqli_num_rows($resultado2);
				$resultado=$basededatos->ejecutar_sql($consulta);
				$total_paginas = ceil($total_registros_sin_limitacion / $TAMANO_PAGINA); 
				if ($total_paginas > 1){
						for ($i=1;$i<=$total_paginas;$i++){
								if ( $pagina == $i){
											//si muestro el índice de la página actual, no coloco enlace
											echo  $pagina . " ";
								}
								else{
											//si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
											echo "<a href='admgestionarwebs.php?pagina=" . $i ."&ordenar=$ordenar' >" . $i . " </a> ";
								}
						}
				}
				echo "<div class='table-responsive'>";
					echo "<table class='table table-striped table-bordered table-hover' width=500px >";
						echo "<tr class='danger'><th>ID</th><th>Enlace</th><th>Nombre</th><th>Descripción</th><th>Fecha</th><th>Tags</th><th>Num. votos</th><th>Media</th><th>Imagen</th><th>Categoría</th><th>Acciones</th></tr>";
						while ($linea = mysqli_fetch_array($resultado)) 
						{
									
									echo "<tr ><td class='col-md-2'>".$linea[idweb]."</td><td class='col-md-2'><a href=admgestionarwebs.php?accion=4&idWeb=$linea[idweb] >".cortarCadena($linea[nombreweb])."</a> </td><td class='col-md-2'>".$linea[tituloweb]."</td><td class='col-md-2'> ".cortarCadena($linea[descripcionweb])."</td><td class='col-md-2'>".cortarCadena($linea[fechaweb])."</td><td class='col-md-2'>".cortarCadena($linea[tagsweb])." </td><td>".$linea[numerovotosweb]."</td><td class='col-md-2'>".$linea[mediavotosweb]."</td><td class='col-md-2'>".cortarCadena($linea[imagenweb])."</td><td class='col-md-2'>".cortarCadena(obtenerNombreCategoria($linea[categoriaweb]))."</td><td class='col-md-2'><a href=admgestionarwebs.php?accion=3&idWeb=$linea[idweb]><img src=../imagenes/eliminar.png></a></img>&nbsp;&nbsp;<a href=admgestionarwebs.php?accion=8&idWeb=$linea[idweb]>incl. pasear</a></td></tr>";
						}
					echo "</table>\n";
				echo "</div>";
				$basededatos->desconectar();
		}
		
	}




	
	
	
	function crearNuevoWeb(){
		?>
		<br />
        <h1><a href='admgestionarwebs.php?accion=40'>Guíame para crear una web</a></h1>
        <br />
		<form method=post action='admgestionarwebs.php' class='form-horizontal' enctype='multipart/form-data'>
		
			<div class='form-group' >
		             <label for='nombreWeb' class='control-label col-md-2'>URL o direccion web:</label>
		            <div class='col-md-10'>
        						<input type='text' class='form-control' name='nombreWeb' id='nombreWeb' size=80 title='Se necesita un nombre' required >
                    </div>
		    </div> 
            <div class='form-group' >
		             <label for='tituloWeb' class='control-label col-md-2'>Nombre de la web:</label>
		            <div class='col-md-10'>
        						<input type='text' class='form-control' name='tituloWeb' id='tituloWeb' size=80 title='Se necesita un título' required >
                    </div>
		    </div> 
		    <div class='form-group' >
		               <label for='descripcionWeb' class='control-label col-md-2'>Descripcion:</label> 
		                <div class='col-md-10'>
                        	<textarea class='form-control' name='descripcionWeb' id='descripcionWeb' rows=10 cols=60></textarea>
                        </div>
		    </div>
		    <div class='form-group' > 
		               <label for='tagsWeb' class='control-label col-md-2'>Tags:</label> 
		               <div class='col-md-10'>
                       		<input type='text' class='form-control' name='tagsWeb' id='tagsWeb' size=80>
                       </div>
		    </div> 
		    <div class='form-group' >
		               <label for='numeroVotosWeb' class='control-label col-md-2'>Número de votos: </label> 
		               <div class='col-md-10'>
                        	<input type='number' class='form-control' name='numeroVotosWeb' id='numeroVotosWeb' title='De 1 a 10000' pattern='[0-9]{1,10000}' placeholder='Num. votos:' required />
                       </div>
		    </div> 
		    <div class='form-group' >  
		              <label for='mediaVotosWeb' class='control-label col-md-2'>Media: </label> 
		              <div class='col-md-10'>
                       		<input type='number' class='form-control' name='mediaVotosWeb' id='mediaVotosWeb' title='De 1 a 10' pattern='[0-9]{1,10}' placeholder='Media:' required />
                      </div>
		    </div> 
		 	<div class='form-group' > 
		 				 <label for='imagenWeb' class='control-label col-md-2'>Foto: </label>  
		 				 <div class='col-md-10' >
                         	<select class='form-control' name='imagenWeb' id='imagenWeb'>  
                            	<option value='sinimagen.jpg' >Sin imagen</option>
                                <?php
								$basededatos= new Mysql();
								$basededatos->conectar_mysql();
								$consulta  = 'SELECT * FROM imagenes ORDER BY idimagen DESC';
								$resultado=$basededatos->ejecutar_sql($consulta);
								while ($linea = mysqli_fetch_array($resultado)) 
								{
									if($linea['nombreimagen'] != "." || $linea['nombreimagen'] != ".."){
										
										echo "<option value='".$linea['nombreimagen']."' >".$linea['nombreimagen']."</option>";
										
									}
								}
								$basededatos->desconectar();
								
								
								?>
                            </select>
                            <input type='file' name='archivo' id='archivo' onChange='ver(form.file.value)' onclick='desabilitarComponenteinamgenWeb()' />
                            <p>La foto debe de estar en tu ordenador.</p>
                         </div> 
		 	</div> 
		    <div class='form-group' >
		             <label for='categoriaweb' class='control-label col-md-2'>Categoria: </label> 
		 			  <div class='col-md-10' >
                          
						<?php echo dibujarLayoutCategorias();?>
                      </div> 
             </div><!-- final del form-group del select idcategoria -->
             <input type=hidden name=accion value=12></input>  
               <div class='form-group' > 
                           <div class='col-md-10 col-md-offset-2' >
                                <input type='submit' value='Crear nueva web con estos datos!' class='btn btn-primary' ></input> 
                           </div>
                </div> 
            
              </form> 
            <?php
	}
	
	
	
	
	
	
	


	
	
	
	
	
	
	
	
	function incluirWebEnPasear($idWeb){
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="INSERT INTO pasear VALUES ( '', '$idWeb','') ";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Web ".$idWeb." incluida en pasear.";
		echo "<script type='text/javascript'>location.href='admgestionarwebs.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
function actualizarWeb($idWeb){
	$basededatos= new Mysql();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT * FROM webs WHERE idweb='".$idWeb."' ";
	$resultado=$basededatos->ejecutar_sql($consulta);
	?>
	<form method='post' action='admgestionarwebs.php?accion=22'>
		<?php while ($linea = mysqli_fetch_array($resultado)) { ?>
			<table class='estiloformulario' border=0 width= 500px >
				<tr> 
					<th valign='top'>URL o direcci&oacute;n</th>
					<td>
						<input type='text' class='form-control' name='nombreWeb' value='<?php echo $linea['nombreweb']?>' required /><hr />
					</td>
				</tr>
				<tr> 
					<th valign='top'>Nombre</th>
					<td><input type='text' class='form-control' name='tituloWeb' value='<?php echo $linea['tituloweb']?>' /><hr /></td>
				</tr>
				<tr> 
					<th valign='top'>Descricpion:</th>
					<td><textarea class='form-control' name=descripcionWeb rows=10 cols=60><?php echo $linea[descripcionweb]?> </textarea></td>
				</tr>
				<tr>
					<th valign='top'>Fecha</th>
					<td><input type='text' class='form-control' name='fechaWeb' value='<?php echo $linea['fechaweb']?>' /></td>
				</tr>
					<th valign='top'>Tags web:</th>
					<td><input type='text' class='form-control' name='tagsWeb' value='<?php echo $linea['tagsweb']?>' /></td>
				</tr>
				<tr>
					<th valign='top'>Número de votos: </th>
					<td><input type='text' class='form-control' name='numeroVotosWeb' value='<?php echo $linea['numerovotosweb']?>' title='De 1 a 10000' pattern='[0-9]{1,10000}' placeholder='Num. votos:' required /></td>
				</tr>
				<tr> 
					<th valign='top'>Media: </th>
					<td><input type='text' class='form-control' name='mediaVotosWeb' value='<?php echo $linea['mediavotosweb']?>' title='De 1 a 10' pattern='[0-9]{1,10}' placeholder='Media:' required /></td>
				</tr>
				<tr> 
					<th valign='top'>Contador: </th>
					<td><input type='text' class='form-control' name='contadorWeb' value='.<?php echo $linea['contadorweb']?>' /></td>
				</tr>
				<tr>
					<th>Categoria: </th>
					<td> 
	                    <?php echo dibujarLayoutCategoriasMostrandoLaCategoriaAsignada($linea['categoriaweb']);?>
	                </td>
				</tr>
				<tr>
					<th>Imagen</th>
					<td>
						<div class='col-md-10' >
							<select class='form-control' name='imagenWeb' id='imagenWeb'>  
								<option value='<?php echo $linea[imagenweb];?>' ><?php echo $linea[imagenweb];?></option>
								<?php
								$basededatos= new Mysql();
								$basededatos->conectar_mysql();
								$consulta  = 'SELECT * FROM imagenes ORDER BY idimagen';
								$resultado=$basededatos->ejecutar_sql($consulta);
								while ($linea = mysqli_fetch_array($resultado)) 
								{
									if($linea['nombreimagen'] != "." || $linea['nombreimagen'] != ".."){
										echo "<option value='".$linea['nombreimagen']."' >".$linea['nombreimagen']."</option>";
									}
								}
								$basededatos->desconectar();
								?>
							 </select>
	                    </div> 
					</td>
				</tr>
				<tr>
					<input type=hidden name=accion value=22></input>	
					<input type=hidden name=idWeb value=<?php echo $idWeb ?>></input>
					<td align=center><a href=admgestionarwebs.php?accion=3&idWeb=<?php echo $idWeb ?> title='Borrar' class='btn btn-primary btn-large'><img src='../imagenes/borrar.png'></img>Borrar</a></td>
					<td align=center><input type=submit value='Actualizar' class='btn btn-primary btn-large' ></td>
				</tr>
			</table>
		<?php } // final del blucle while para ver los resultados de la base de datos ?>
	</form>	
	<?php }
		
	function confirmarBorrarWeb($idWeb){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar ".obtenerNombreWeb($idWeb)."?, es muy bonito...</h3><br /><img src=../imagenes/bonito".$foto.".jpg></img><br />";
		echo "<h1><a href='admgestionarwebs.php?accion=5&idWeb=$idWeb'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='admgestionarwebs.php?accion=6&idWeb=$idWeb'>NO</a></h1>";	
	}
	function borrarWeb($idWeb){
		
		
		
			$mensaje=obtenerNombreWeb($idWeb)." borrado. ";
			$bd= new Mysql();
			$bd->conectar_mysql();
			$sql="DELETE FROM webs WHERE idWeb='$idWeb' LIMIT 1";
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			echo "<script type='text/javascript'>location.href='admgestionarwebs.php?mensaje=$mensaje'</script>";
		
		
			
		
	}
	function redirigirPorNoBorrar($idWeb){
		$mensaje=obtenerNombreWeb($idWeb)."No borrado";
		echo "<script type='text/javascript'>location.href='admgestionarwebs.php?mensaje=$mensaje'</script>";
	}
	
	function mostrarUnWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idweb='".$idWeb."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo"<table class='estiloformulario' border=0 width= 500px >";
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			
				echo"  <tr> ";
				echo"              <th valign='top'>Direcci&oacute;n o URL</th>";
				echo"              <td><h3>".$linea['nombreweb']."</h3></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre web</th>";
				echo"              <td><h3>".$linea['tituloweb']."</h3><hr /></td>";
				echo"   </tr>";
				echo"   <tr> ";
				echo"              <th valign='top'>Descricpion:</th>";
				echo"              <td><textarea class='form-control'>".$linea['descripcionweb']."</textarea></td>";
				echo"    </tr>";
				echo"              <th valign='top'>Fecha</th>";
				echo"              <td>".$linea['fechaweb']."</td>";
				echo"   </tr>";
				echo"              <th valign='top'>Tags web:</th>";
				echo"              <td>".$linea['tagsweb']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Número de votos: </th>";
				echo"              <td>".$linea['numerovotosweb']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Voto: </th>";
				echo"              <td>".$linea['mediavotosweb']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Contador: </th>";
				echo"              <td>".$linea['contadorweb']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Imagen: </th>";
				echo"              <td><div class='contenedorimagenesdewebs'><img src='../imagenes/webs/".$linea['imagenweb']."' width='500px' /></div></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Categoria: </th>";
				echo"              <td>".obtenerNombreCategoria($linea['categoriaweb'])."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				//echo"              <td><a href=admgestionarwebs.php?accion=3&idWeb=".$idWeb." title='Borrar'><img src='../imagenes/borrar.png'></img>Borrar</a></td>";
				echo"              <td colspan=2  align=center><a href=admgestionarwebs.php?accion=2&idWeb=".$idWeb." title='Editar' class='btn btn-primary'><img src='../imagenes/actualizar.png' >Editar</img></a></td>";
				echo"   </tr>";
			
		}
		echo"</table>";
		$basededatos->desconectar();

		
	
	}
	
	function aplicarInsercionWeb(){
			$nombre=$_POST['nombreWeb'];
			$nombreacortar=substr($nombre, 0, 7);
			$nombreacortar2=substr($nombre, 0, 8);
			if($nombreacortar=='http://'){
				$nombreCortado=substr($nombre,7 ,strlen($nombre));
			}else if($nombreacortar2=='https://'){
				$nombreCortado=substr($nombre,8 ,strlen($nombre));
			}else{
				$nombreCortado=$_POST['nombreWeb'];
			}
			$fecha=date("j/n/Y");
			$_POST[numerovotosweb]=$_POST[numerovotosweb]+1;
			$bd= new Mysql();
			$bd->conectar_mysql();
			print($_FILES['archivo']['name']);
			if(!empty($_FILES['archivo']['name'])){
				$nombre_archivo = $_FILES['archivo']['name']; 
				aplicarInsercionImagenSinRedirigir();
				$sql="INSERT INTO webs VALUES ( '', '$nombreCortado', '$_POST[tituloWeb]','$_POST[descripcionWeb]','$fecha', '$_POST[tagsWeb]', '$_POST[numeroVotosWeb]','$_POST[mediaVotosWeb]', '0','$nombre_archivo','$_POST[categoriaweb]') ";
			}else{
				$sql="INSERT INTO webs VALUES ( '', '$nombreCortado', '$_POST[tituloWeb]','$_POST[descripcionWeb]','$fecha', '$_POST[tagsWeb]', '$_POST[numeroVotosWeb]','$_POST[mediaVotosWeb]', '0','$_POST[imagenWeb]','$_POST[categoriaweb]') ";
			}
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			$mensaje="Web ".$nombreCortado." nueva insertada.";
			echo "<script type='text/javascript'>location.href='admgestionarwebs.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	function aplicarActualizacionWeb($idWeb){
		$nombre=$_POST['nombreWeb'];
		$nombreacortar=substr($nombre, 0, 7);
		$nombreacortar2=substr($nombre, 0, 8);
		if($nombreacortar=='http://'){
			$nombreCortado=substr($nombre,7 ,strlen($nombre));
		}else if($nombreacortar2=='https://'){
			$nombreCortado=substr($nombre,8 ,strlen($nombre));
		}else{
			$nombreCortado=$_POST['nombreWeb'];
		}
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update webs set nombreWeb='$nombreCortado', tituloweb='$_POST[tituloWeb]', descripcionweb='$_POST[descripcionWeb]', fechaweb='$_POST[fechaWeb]', tagsweb='$_POST[tagsWeb]', numerovotosweb='$_POST[numeroVotosWeb]', mediavotosweb='$_POST[mediaVotosWeb]', contadorweb='$_POST[contadorWeb]', imagenweb='$_POST[imagenWeb]', categoriaweb='$_POST[categoriaweb]' where idweb='$idWeb'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Web ".obtenerNombreWeb($idWeb)." actualizado.";
		echo "<script type='text/javascript'>location.href='admgestionarwebs.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	
	
	
	
/***************************Main*********************************************/
	if (!isset($_GET['accion']) && $_POST['accion']<40 && $_POST['accion']!=12 ){
		dibujarWebs();
	}else{
		if ($_GET['accion']==1){
			crearNuevoWeb();
		}else if($_GET['accion']==2){
			actualizarWeb($_GET['idWeb']);
		}else if($_GET['accion']==3){
			echo "pasa por confirmar borrado";
			confirmarBorrarWeb($_GET['idWeb']);
		}else if($_GET['accion']==5){
			borrarWeb($_GET['idWeb']);
		}else if($_GET['accion']==6){
			redirigirPorNoBorrar($_GET['idWeb']);
		}else if($_GET['accion']==4){
			mostrarUnWeb($_GET['idWeb']);
		}else if($_GET['accion']==7){
			cerrarSesion();
		}else if($_GET['accion']==8){
			incluirWebEnPasear($_GET['idWeb']);
		}else if($_GET['accion']==40){
			dameUnaCategoria();
		}else if($_GET['accion']==43){
			rellenarRestoCamposWeb();
		}else if($_GET['accion']==44){
			crearNuevaCategoria();
		}
		
		
		 
	}
	
	if($_POST['accion'] == 12){
			aplicarInsercionWeb();
	}else if($_POST['accion'] == 22){
			aplicarActualizacionWeb($_POST['idWeb'], $_POST);
	}else if($_POST['accion']==41 || $_GET['accion']==41){
			dameUnaFoto();
	}else if($_POST['accion']==42){
		//subir imagen al servidor de china
		aplicarInsercionImagen($_FILES);
	}else if($_POST['accion']==45){
		aplicarInsercionCategoria($_POST);
	}
/****************************************************************************/








	
dibujarPaginaAbajoAdministrador();
?>

