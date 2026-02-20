	<?php

	function showCategory($idCategoria){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		//botón para crear una nueva categoria
		echo "<a href='".PATHSERVER."gestionarcategorias.php?accion=1' class='btn btn-primary btn-large'>Create new</a><br /><br />";
		//Botón para actualizar esta categoria
		echo "<a href='".PATHSERVER."gestionarcategorias.php?accion=2&idCategoria=$idCategoria' class='btn btn-warning btn-large'>Update</a><br /><br />";
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias WHERE idcategoria='".$idCategoria."' AND idUsuario='".$idUsuario."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			echo "<h1>".$linea['nombrecategoria']."</h1>";
			echo "<p>".$linea['titulocategoria']."</p>";
			echo "<p>Es hija de: ".$linea['categoriaeshijade']."</p>";
			echo "<p>Nivel: ".$linea['nivelcategoria']."</p>";
			echo "<p>Redirecciona a categoria: ".$linea['redireccionaidcategoria']."</p>";
			echo "<p>Webs de esta categoria:</p>";
			obtenerTodasLasWebsDeUnaCategoriaParaLista($linea['idcategoria']);
		}
		$basededatos->desconectar();
	}

	function obtenerNombreCategoria($idCategoria){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias WHERE idcategoria='".$idCategoria."' AND idUsuario='".$idUsuario."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['nombrecategoria'];
		}
		$basededatos->desconectar();
	}
    function recorrerCategorias($nivelCategoria, $categoriaeshijade){//Esta funcion es solo par alos usuarios registrados
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$nivelCategoria++;
		$espacios="";
		$basededatos1= new Mysql();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias WHERE nivelcategoria='".$nivelCategoria."' AND idpadrecategoria='".$categoriaeshijade."' AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1)) 
		{
			echo "<li>".$espacios."|__  <a href=".PATHSERVER."gestionarwebs.php?categoriaweb=$linea1[idcategoria] > ".$linea1['nombrecategoria']."</a></li>";
			if ($linea1['categoriaeshijade'] != null){
				recorrerCategorias($nivelCategoria, $linea1['idcategoria'] );							
			}
		}
		$basededatos1->desconectar();
	}
	
	function recorrerCategoriasConSelect($nivelCategoria, $categoriaeshijade){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$nivelCategoria++;
		$espacios="";
		$basededatos1= new Mysql();
		$basededatos1->conectar_mysql();
		//$consulta1  = "SELECT * FROM categorias_".$idUsuario." WHERE nivelcategoria='".$nivelCategoria."' && idpadrecategoria='".$categoriaeshijade."' ORDER BY nombrecategoria";
		$consulta1  = "SELECT * FROM categorias WHERE idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=1;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1 )) 
		{
			echo "<option value='".$linea1['idcategoria']."' >".$espacios.$linea1['nombrecategoria']."</option>";
			if ($linea1['categoriaeshijade'] != null){
				 recorrerCategoriasConSelect($nivelCategoria, $linea1[idcategoria] );			
			}
		}
		$basededatos1->desconectar();
	}


	/*function dibujarLayoutCategorias(){//Esta funcion es para los usuaros registrados
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$nivelCategoria=1;
		//echo "<div class='col-xs-6 col-md-2'>";
			$basededatos= new Mysql();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
			$resultado=$basededatos->ejecutar_sql($consulta);
			echo "<ul style='list-style:none'>";
					while ($linea = mysqli_fetch_array($resultado)) 
					{
							echo "<li> <a href=".PATHSERVER."gestionarwebs.php?categoriaweb=$linea[idcategoria] > ".$linea['nombrecategoria']."</a></li>";
							recorrerCategorias($nivelCategoria, $linea['idcategoria'] );	
					}
					$basededatos->desconectar();
			echo "</ul>";
		//echo "</div>";
	}*/


	
	function buscarCategoria($tagsCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias WHERE nombrecategoria LIKE '%".$tagsCategoria."%' ||  titulocategoria LIKE '%".$tagsCategoria."%' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$total_registros=mysqli_num_rows($resultado);
		
		if($total_registros==FALSE){
			echo" <p>No se obtuvo ning&uacute;n resultado de ".$tagsCategoria.".</p>"	;
		}else{
			echo "<p class='font-weight-bolder'>".$total_registros." categorías encontradas.</p>";
			echo "<table class='table'>";
			while ($linea = mysqli_fetch_array($resultado)) 
			{
			
				
					echo "<tr>";
						echo "<td><a href='categoria/$linea[idcategoria]'>".$linea[nombrecategoria]."</td>";
						echo "<td><a href='categoria/$linea[idcategoria]'>".$linea[titulocategoria]."</td>";
					echo "</tr>";

					//if($linea['redireccionaidcategoria']!=0) echo "<center ><a href='categoria/$linea[redireccionaidcategoria]'>".$linea[titulocategoria]."</a></center>";
					//else echo "<center ><a href='categoria/$linea[idcategoria]'>".$linea[titulocategoria]."</a></center>";				
				
			
				
			}
			echo "</table>";
		}
		$basededatos->desconectar();
	}


	function obtenerTodasLasWebsDeUnaCategoriaParaLista($idCategoria){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombreweb,tituloweb FROM webs WHERE idCategoria='".$idCategoria."' AND idUsuario='".$idUsuario."' ORDER BY nombreweb";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo "<ul>";
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			echo "<li><a href='http://".$linea['nombreweb']."' target='_blank' ><span style='font-size:12px; color:red'>".$linea['tituloweb']."</span></a></li>";
		}
		echo "</ul>";
		$basededatos->desconectar();
	}
	function sideMenuUsersInside($nivelCategoria, $categoriaeshijade){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$nivelCategoria++;
		$espacios="";
		$basededatos1= new Mysql();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias WHERE nivelcategoria='".$nivelCategoria."' AND idpadrecategoria='".$categoriaeshijade."' AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1 )) 
		{
			echo "<li>".$espacios."|__  <a href=".PATHSERVER."gestionarcategorias.php?accion=4&idCategoria=$linea1[idcategoria] >$linea1[nombrecategoria]</a>";
				obtenerTodasLasWebsDeUnaCategoriaParaLista($linea1['idcategoria']);
			echo "</li>";
			if ($linea1['categoriaeshijade'] != null){
				sideMenuUsersInside($nivelCategoria, $linea1['idcategoria'] );							
			}
		}
		$basededatos1->desconectar();
	}



	function sideMenuUsers(){//Esta funcion es para los usuaros registrados
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		//Para ver las categorias: SELECT * FROM categorias WHERE nivelcategoria='1' AND idUsuario='2' ORDER BY nombrecategoria;
		$nivelCategoria=1;
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta= "SELECT * FROM categorias WHERE nivelcategoria='".$nivelCategoria."' AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
		$resultado=$basededatos->ejecutar_sql($consulta);
		if(mysqli_num_rows($resultado)==null || mysqli_num_rows($resultado)==0){
			echo "<p>No hay webs creadas</p>";
		}else{
			echo "<ul style='list-style:none'>";
			while ($linea = mysqli_fetch_array($resultado )) 
			{
				echo "<li> <a href='".PATHSERVER."gestionarcategorias.php?accion=4&idCategoria=$linea[idcategoria]'>$linea[nombrecategoria]</a></li>";
					sideMenuUsersInside($nivelCategoria, $linea['idcategoria'] );	
			}
		}
		$basededatos->desconectar();
		echo "</ul>";
	}

	/**
	 * Tabla categorias
	 */
	function showCategories(){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$nivelCategoria=2;

		echo "<div class='table-responsive'>";
			echo "<table class='table table-responsive table-hover table-condensed' >";
				echo "<tr class='danger'>
						<th>id</th>
						<th>Nombre</th>
						<th>titulo</th>
						<th>hijade</th>
						<th>idpadre</th>
						<th>nivel</th>
						<th>|_></th>
						<th>Accion</th>
				</tr>";
				$basededatos= new Mysql();
				$basededatos->conectar_mysql();
				$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
				$resultado=$basededatos->ejecutar_sql($consulta);
		
				while ($linea = mysqli_fetch_array($resultado)) 
				{
					echo "<tr>";
						echo "<td>".$linea['idcategoria']."</td>
						<td><a href='".PATHSERVER."gestionarcategorias.php?accion=4&idCategoria=$linea[idcategoria]'>$linea[nombrecategoria]</a></td>
						<td>".$linea['titulocategoria']."</td>
						<td>".$linea['categoriaeshijade']."</td>
						<td>".$linea['idpadrecategoria']."</td>
						<td>".$linea['nivelcategoria']."</td>
						<td>".$linea['redireccionaidcategoria']."</td>";
						//echo "<li><a href=".PATHSERVER."gestionarwebs.php?categoriaweb=$linea[idcategoria] >".$linea['nombrecategoria']."</a></li>";
						//echo "hay va el nuvel ".$nivelCategoria." el nombre: ".$linea['nombrecategoria'] ."<br>";
						recorrerCategorias($nivelCategoria,0 );	
						echo "<td class='col-md-2'>
							<a href=".PATHSERVER."gestionarcategorias.php?accion=4&idCategoria=$linea[idcategoria]>
								<img src='".PATHSERVER."imagenes/ojo.png' width='20' height='20'/>
							</a>&nbsp;
							<a href=".PATHSERVER."gestionarcategorias.php?accion=2&idCategoria=$linea[idcategoria]>
								<img src='".PATHSERVER."imagenes/actualizar.png' width='20' height='20'/>
							</a>&nbsp;
							<a href=".PATHSERVER."gestionarcategorias.php?accion=3&idCategoria=$linea[idcategoria]>
								<img src='".PATHSERVER."imagenes/eliminar.png' width='20' height='20'/>
							</a>&nbsp;
						</td>";
					echo "</tr>";
				}
				$basededatos->desconectar();
				echo "</table>";
		echo "</div>";	

	}


	function insert(){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		echo"<p>Menu insertar nueva categoria</p>";
		echo"<form method=post action='".PATHSERVER."gestionarcategorias.php' class='form-horizontal'>";
	
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
								$basededatos= new Mysql();
								$basededatos->conectar_mysql();
								$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
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
				echo "<input type=hidden name=accion value=12></input> ";
				echo"<input type=submit value='Insertar nueva categoria' class='btn btn-primary btn-large' ></input>";
			echo"    </div>";
		echo"    </div>";
		echo" </form>";
	}





	function update($idCategoria){
		// echo "vamos a ver la categoria: ".$idCategoria;
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias WHERE idCategoria='".$idCategoria."' AND idUsuario='".$idUsuario."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$categoria=null;
		while ($linea = mysqli_fetch_array($resultado)) 
		{
				$categoria=new Categoria($linea['idcategoria']);
				$categoria->setNombreCategoria($linea['nombrecategoria']);
				$categoria->setTituloCategoria($linea['titulocategoria']);
				$categoria->setNivelCategoria($linea['nivelcategoria']);
				$categoria->setCategoriaEsHijaDe($linea['categoriaeshijade']);
				$categoria->setIdPadreCategoria($linea['idpadrecategoria']);
		
		}
		$basededatos->desconectar();
		echo"<p>Menu Actualizar categoria: ".obtenerNombreCategoria($categoria->getIdCategoria())."</p>";
	
		echo"<form method=post action='".PATHSERVER."gestionarcategorias.php' >";
				echo" <label for='nombreCategoria' class='control-label'>Nombre categoria:</label>";
				echo"<input type= text  name='nombreCategoria' id='nombreCategoria' value='".$categoria->getNombreCategoria()."' class='form-control' title='El nombre debe de contener entre 4 y 50 letras o números' placeholder='Nombre:' pattern='[a-zA-Z0-9\d_- áéíóúÁÉÍÓÚÑñ]{4,50}' required></input>";
				echo"<input type=hidden name=accion value=22></input>";	
				echo"<input type=hidden name=idCategoria value='".$categoria->getIdCategoria()."'></input>";
				echo"<input type=submit value='Actualizar nombre' class='btn btn-primary btn-large' >";
		echo" </form>";
		
		echo"<form method=post action='".PATHSERVER."gestionarcategorias.php' >";
				echo" <label for='tituloCategoria' class='control-label'>T&iacute;tulo:</label>";
				echo"<input type= text  name='tituloCategoria' id='tituloCategoria' value='".$categoria->getTituloCategoria()."' class='form-control' title='El t&iacute;tulo debe de contener entre 4 y 5000 letras o números' placeholder='Nombre:' pattern='[a-zA-Z0-9\d_- áéíóúÁÉÍÓÚÑñ]{4,5000}' required></input>";
				echo"<input type=hidden name=accion value=24></input>";	
				echo"<input type=hidden name=idCategoria value='".$categoria->getIdCategoria()."'></input>";
				echo"<input type=submit value='Actualizar t&iacute;tulo' class='btn btn-primary btn-large' >";
		echo" </form>";
		
		
		echo"<form method=post action='".PATHSERVER."gestionarcategorias.php' >";
		echo" <div class='form-group' > ";
		
			echo " <label for='categoriaEsHijaDe' class='control-label '>Cambiar a hija de:</label>";
			echo" <div  > ";
				//echo "Asignado:<p>".$categoria->getCategoriaEsHijaDe()."</p>";
				echo "<select name='categoriaEsHijaDe' class='form-control' required> ";
								echo "<option value='".$categoria->getIdCategoria()."' >".$categoria->getCategoriaEsHijaDe()."</option>";
								//echo "<option value='Base' >Base</option>";
								$nivelCategoria=1;
								$basededatos= new Mysql();
								$basededatos->conectar_mysql();
								$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
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
			echo "<div  >";
				echo" 		   <input type=hidden name=accion value=23></input>";	
				echo" 		   <input type=hidden name=idCategoria value=".$_GET['idCategoria']."></input>";
				echo"          <input type=submit value='Actualizar grupo' class='btn btn-primary btn-large' >";
			echo"    </div>";
		echo"    </div>";
	
		echo" </form>";
				
	}




		
	function confirmarBorrarCategoria($idCategoria){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar ".obtenerNombreCategoria($idCategoria)."?, es muy bonita...</h3><br /><img src='".PATHSERVER."imagenes/bonito".$foto.".jpg' class='img-responsive' /><br />";
		echo "<h1><a href='".PATHSERVER."gestionarcategorias.php?accion=5&idCategoria=$idCategoria'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='".PATHSERVER."gestionarcategorias.php?accion=6&idCategoria=$idCategoria'>NO</a></h1>";	
	}
	
	
	
	function comprobarSiOtrasTienenEstaCategoriaComoPadre($idCategoria){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias WHERE idpadrecategoria='".$idCategoria."' AND idUsuario='".$idUsuario."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		if(mysqli_num_rows($resultado)>0){
			return true;
		}else{
			return false;	
		}
		$basededatos->desconectar();
		
	}
	
	
	
	function borrarCategoria($idCategoria){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
			$comprobacionPadre=comprobarSiOtrasTienenEstaCategoriaComoPadre($idCategoria);
			if($comprobacionPadre==true){
				$mensaje=" La categoria: ".obtenerNombreCategoria($idCategoria).", tiene hijos y no puede ser borrada.";
				echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarcategorias.php?mensaje=$mensaje'</script>";
			}else{
				$mensaje=obtenerNombreCategoria($idCategoria)." borrada. ";
				$bd= new Mysql();
				$bd->conectar_mysql();
				$sql="DELETE FROM categorias WHERE idCategoria='".$idCategoria."' AND idUsuario='".$idUsuario."' LIMIT 1";
				$bd->ejecutar_sql($sql);
				$bd->desconectar();
				echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarcategorias.php?mensaje=$mensaje'</script>";
			}
	}
	function redirigirPorNoBorrar($idCategoria){
		$mensaje=obtenerNombreCategoria($idCategoria).", no borrado";
		echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarcategorias.php?mensaje=$mensaje'</script>";
	}
	

	function aplicarInsercionCategoria(){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		if(obtenerTotalRegistros()>1000){
			$mensaje="Categoría no insertada, no puedes meter más de 20 categorías.";
			echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarwebs.php?mensaje=".$mensaje."';</script>";
		}else{
			$nivelCategoria=obtenerNivelCategoria($_POST[categoriaEsHijaDe]);
			$nivelCategoria++;
			$nombrePadre=obtenerNombreCategoria($_POST[categoriaEsHijaDe]);
			$bd2= new Mysql();
			$bd2->conectar_mysql();
			$sql2="INSERT INTO categorias VALUES ( '', '$_POST[nombreCategoria]', '$_POST[tituloCategoria]','$nombrePadre', '$_POST[categoriaEsHijaDe]', '$nivelCategoria', '".$idUsuario."') ";
			$bd2->ejecutar_sql($sql2);
			$bd2->desconectar();
			$mensaje="Categoria ".$_POST[nombreCategoria]." nueva insertada.";
			echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarcategorias.php?mensaje=".$mensaje."';</script>";
		}
	}

	
	function aplicarActualizacionNombreCategoria($idCategoria){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update categorias set nombrecategoria='$_POST[nombreCategoria]' where idcategoria='$idCategoria' AND idUsuario='".$idUsuario."'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		actualizarTodosLosNombreConElIdPadreCategoria($idCategoria);
		$mensaje="Categoria ".obtenerNombreCategoria($idCategoria)." actualizada.";
		echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarcategorias.php?mensaje=".$mensaje."';</script>";
	}
	
	function aplicarActualizacionTituloCategoria($idCategoria){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update categorias set titulocategoria='$_POST[tituloCategoria]' where idcategoria='$idCategoria' AND idUsuario='".$idUsuario."'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Titulo de la categoria ".obtenerNombreCategoria($idCategoria)." actualizado.";
		echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarcategorias.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	function aplicarActualizacionPadreCategoria($idCategoria){
		if($_POST[categoriaEsHijaDe] != $idCategoria){
			$idUsuario=1;
			if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
			$nombreCategoria=obtenerNombreCategoria($idCategoria);
			$nivelCategoria=obtenerNivelCategoria($_POST[categoriaEsHijaDe]);
			$nivelCategoria++;
			$nombrePadre=obtenerNombreCategoria($_POST[categoriaEsHijaDe]);	
			$bd= new Mysql();
			$bd->conectar_mysql();
			$sql="update categorias set nombrecategoria='$nombreCategoria', categoriaeshijade='$nombrePadre', idpadrecategoria='$_POST[categoriaEsHijaDe]', nivelcategoria='$nivelCategoria' where idcategoria='$idCategoria' AND idUsuario='".$idUsuario."'";
			/*$sql="update categorias_".$idUsuario." set nombrecategoria='$nombreCategoria', categoriaeshijade='$nombrePadre', idpadrecategoria='$_POST[categoriaEsHijaDe]', nivelcategoria='$nivelCategoria' where idcategoria='$idCategoria'";*/
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			actualizarTodosLosNombreConElIdPadreCategoria($idCategoria);
			$mensaje="Categoria ".obtenerNombreCategoria($idCategoria)." actualizada.";
			echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarcategorias.php?mensaje=".$mensaje."';</script>";
		}else{
			echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarcategorias.php?';</script>";
		}
	}
	
