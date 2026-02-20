<?php

	


	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	

	
	function dibujarLayoutCategorias($nivelCategoria){
					echo "<select name='categoriaweb' class='form-control col-md-6' required> ";
									$nivelCategoria+=1;
									$basededatos= new mysqlusuarios();
									$basededatos->conectar_mysql();
									$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
									$resultado=$basededatos->ejecutar_sql($consulta);
									while ($linea = mysqli_fetch_array($resultado )) 
									{
											echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
											recorrerCategoriasConSelect($nivelCategoria, $linea['idcategoria'] );
									}
									$basededatos->desconectar();
				echo "</select>";
					
		}
		
		
	
	

	function dibujarLayoutCategoriasDos($nivelCategoria){
				echo"<form method=post action='usuariosgestionarwebs.php'>";
				echo "<select name='categoriaweb' class='form-control col-md-6' required> ";
								$nivelCategoria+=1;
								$basededatos= new mysqlusuarios();
								$basededatos->conectar_mysql();
								$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
								$resultado=$basededatos->ejecutar_sql($consulta);
								while ($linea = mysqli_fetch_array($resultado )) 
								{
										echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
										recorrerCategoriasConSelect($nivelCategoria, $linea['idcategoria'] );
								}
								$basededatos->desconectar();
						echo "</select>";
				echo"<input type=submit value='Por categoría'  class='btn btn-default'></input>";
				echo "</form>";
			
	}

	function dibujarLayoutCategoriasMostrandoLaCategoriaAsignada($categoriaAsignada){
					
					echo "<select name='categoriaweb' class='form-control col-md-6' required> ";
							echo "<option value='".$categoriaAsignada."' style='background:yellow'>".obtenerNombreCategoria($categoriaAsignada)."</option>";
									$nivelCategoria=1;
									$basededatos= new mysqlusuarios();
									$basededatos->conectar_mysql();
									$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
									$resultado=$basededatos->ejecutar_sql($consulta);
									while ($linea = mysqli_fetch_array($resultado )) 
									{
											echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
											recorrerCategoriasConSelect($nivelCategoria, $linea['idcategoria'] );
									}
									$basededatos->desconectar();
				echo "</select>";
					
		}
	
	
	
	



	function dibujarWebs(){
		?>
			<a href='usuariosgestionarwebs.php?accion=1' class='btn btn-danger'>Crear nueva web</a>&nbsp;&nbsp;
            <a href="#" id="mostrarOculatr" class="btn btn-info">Configuraci&oacute;n</a>&nbsp;&nbsp;
            <div  style="background-color:yellow">
                    <div class="btn-group">
                          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Ordenar
                              <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" >
                               <li><a href=usuariosgestionarwebs.php?ordenar=nombreweb >Por nombre</a></li>
                               <li><a href=usuariosgestionarwebs.php?ordenar=mediavotosweb >Por votos</a></li>
                               <li><a href=usuariosgestionarwebs.php?ordenar=imagenweb >Por foto</a></li>
                                <li><a href=usuariosgestionarwebs.php?ordenar=idweb c>Por ID</a></li>
                          </ul>
                     </div>
                     <form method=post action='usuariosgestionarwebs.php'>
                            <label for="tituloWeb" class="label-control">Buscar</label>
                            <input type='text' class='form-control' name='tituloWeb' id='tituloWeb' size=80 title='Se necesita un nombre' placeholder='Escribe el nombre de la web a buscar aquí'  required >
                            <input type='submit' value='Por nombre' class='btn btn-default' ></input> 
                    </form>
                    <?php
                       dibujarLayoutCategoriasDos(0);
                    ?>
         </div><!-- final del menu usuarios web -->
         <?php
		$TAMANO_PAGINA = 10;
		if (isset($_GET["ordenar"])){
			$ordenar=$_GET["ordenar"];
		}else{
			$ordenar="categoriaweb";
		}
		
		
		$pagina = $_GET["pagina"];
		
		if (!$pagina) {
			$inicio = 0;
			$pagina=1;
		}
		else {
			$inicio = ($pagina - 1) * $TAMANO_PAGINA;
		} 
					
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		if(isset($_POST['categoriaweb'])){
			$consulta  = "SELECT * FROM webs_".$_SESSION['idusuario']." WHERE categoriaweb='".$_POST['categoriaweb']."' GROUP BY ".$ordenar." DESC limit " . $inicio . "," . $TAMANO_PAGINA."";
			$consulta2  = "SELECT * FROM webs_".$_SESSION['idusuario']." WHERE categoriaweb='".$_POST['categoriaweb']."' GROUP BY ".$ordenar." DESC ";
		}else if(isset($_GET['categoriaweb'])){
			$consulta  = "SELECT * FROM webs_".$_SESSION['idusuario']." WHERE categoriaweb='".$_GET['categoriaweb']."' ORDER BY ".$ordenar." DESC limit " . $inicio . "," . $TAMANO_PAGINA."";
			$consulta2  = "SELECT * FROM webs_".$_SESSION['idusuario']." WHERE categoriaweb='".$_GET['categoriaweb']."' ORDER BY ".$ordenar." DESC ";
		}else if(isset($_POST['tituloWeb'])){
			$consulta  = "SELECT * FROM webs_".$_SESSION['idusuario']." WHERE tituloweb LIKE '%".$_POST['tituloWeb']."%' ORDER BY ".$ordenar." DESC limit " . $inicio . "," .$TAMANO_PAGINA."";
			$consulta2  = "SELECT * FROM webs_".$_SESSION['idusuario']." WHERE tituloweb LIKE '%".$_POST['tituloWeb']."%' ORDER BY ".$ordenar." DESC";
		}else{
			$consulta  = "SELECT * FROM webs_".$_SESSION['idusuario']." ORDER BY ".$ordenar." DESC limit " . $inicio . "," .$TAMANO_PAGINA."";
			$consulta2  = "SELECT * FROM webs_".$_SESSION['idusuario']." ORDER BY ".$ordenar." DESC ";
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
											echo "<a href='usuariosgestionarwebs.php?pagina=" . $i ."&ordenar=$ordenar' >" . $i . " </a> ";
								}
						}
				}
				echo "<div class='table-responsive'>";
					echo "<table class='table table-responsive table-hover table-condensed' >";
						echo "<tr class='danger'><th>Grupo</th><th>Nombre</th><th>Descripción</th><th>Fecha</th><th>Num. votos</th><th>Media</th><th>Acciones</th></tr>";
						$variableCategoriaWeb="";
						$colorFila=array("warning", "warning", "info", "success", "danger", "active");
						$color="";
						$posicion=0;
						//$contadorSalto=0;
						while ($linea = mysqli_fetch_array($resultado )) 
						{
									//Aqui le pones el color e fondo a las filas
									if ($linea['categoriaweb']!=$variableCategoriaWeb){
										if($posicion==count($colorFila)){
											$posicion=0;
										}
										$posicion++;
										$color=$colorFila[$posicion];
									}
									echo "<tr class='".$color."'><td class='col-md-1'><div class='rotar'>";
									
									if($linea['categoriaweb']!=$variableCategoriaWeb){
										/*for ($i=0;$i<strlen($contadorSalto);$i++){
												echo "<br />";
										}*/
										echo cortarCadena(obtenerNombreCategoria($linea['categoriaweb']));
									}else{
										//$contadorSalto++;
										//echo "-----------";
									}
									
									echo "</div></td><td class='col-md-3'><a href='http://".$linea['nombreweb']."' target='_blank' >".$linea['tituloweb']."</a></td><td class='col-md-4'> ".cortarCadena($linea['descripcionweb'])."</td><td>".cortarCadena($linea['fechaweb'])."</td><td> ".$linea['numerovotosweb']."</td><td>".$linea['mediavotosweb']."</td><td class='col-md-4'><a href=usuariosgestionarwebs.php?accion=3&idWeb=$linea[idweb]><img src=../imagenes/eliminar.png></a></img>&nbsp;<a href=usuariosgestionarwebs.php?accion=4&idWeb=$linea[idweb] ><img src=../imagenes/ojo.png width='40px'></a></img></a>&nbsp;<a href=usuariosgestionarwebs.php?accion=2&idWeb=$linea[idweb] ><img src=../imagenes/actualizar.png></a></td></tr>";
									$variableCategoriaWeb=$linea['categoriaweb'];
						}
					echo "</table>\n";
				echo "</div>";
				$basededatos->desconectar();
		}
		
	}




	
	
	
	function crearNuevoWeb(){
		?>
		<form method='post' action='usuariosgestionarwebs.php' class='form-horizontal'>
		
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
		               <label for='numeroVotosWeb' class='control-label col-md-2'>Número de votos: </label> 
		               <div class='col-md-10'>
                        	<!--<input type='number' class='form-control' name='numeroVotosWeb' id='numeroVotosWeb' title='De 1 a 10000' pattern='[0-9]{1,5}' placeholder='Num. votos:' required />-->
                            <input type='text' class='form-control' name='numeroVotosWeb' value='' title='De 1 a 10000' pattern='[0-9]{1,5}' placeholder='Num. votos:' required />
                       </div>
		    </div> 
		    <div class='form-group' >  
		              <label for='mediaVotosWeb' class='control-label col-md-2'>Media: </label> 
		              <div class='col-md-10'>
                       		<!-- <input type='number' class='form-control' name='mediaVotosWeb' id='mediaVotosWeb' title='De 1 a 10' pattern='[0-9]{1}' placeholder='Media:' required /> -->
                            <input type='text' class='form-control' name='mediaVotosWeb' value='' title='De 1 a 10' pattern='[0-9]{1}' placeholder='Num. votos:' required />
                      </div>
		    </div> 
		    <div class='form-group' >
		             <label for='categoriaweb' class='control-label col-md-2'>Categoria: </label> 
		 			  <div class='col-md-10' >
						<?php echo dibujarLayoutCategorias(0);?>
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
		$bd= new mysqlusuarios();
		$bd->conectar_mysql();
		$sql="INSERT INTO pasear VALUES ( '', '$idWeb','') ";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Web ".$idWeb." incluida en pasear.";
		echo "<script type='text/javascript'>location.href='usuariosgestionarwebs.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
function actualizarWeb($idWeb){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs_".$_SESSION['idusuario']." WHERE idweb='".$idWeb."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo"<table class='estiloformulario' border=0 width= 500px >";
		echo "<form method='post' action='usuariosgestionarwebs.php' class='form-horizontal'>";
		while ($linea = mysqli_fetch_array($resultado )) 
		{
				
				echo"  <tr> ";
				echo"              <th valign='top'>URL odirecci&oacute;n</th>";
				echo"              <td><input type='text' class='form-control' name='nombreWeb' value='".$linea['nombreweb']."' required /><hr /></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre</th>";
				echo"              <td><input type='text' class='form-control' name='tituloWeb' value='".$linea['tituloweb']."' /><hr /></td>";
				echo"   </tr>";
				echo"   <tr> ";
				echo"              <th valign='top'>Descricpion:</th>";
			
				echo" 					<td><textarea class='form-control' name=descripcionWeb rows=10 cols=60>".$linea['descripcionweb']." </textarea></td>";
				echo"    </tr>";
				echo"              <th valign='top'>Fecha</th>";
				echo"              <td><input type='text' class='form-control' name='fechaWeb' value='".$linea['fechaweb']."' /></td>";
				echo"  <tr> ";
				echo"              <th valign='top'>Nº de votos: </th>";
				echo"              <td><input type='text' class='form-control' name='numeroVotosWeb' value='".$linea['numerovotosweb']."' title='De 1 a 10000' pattern='[0-9]{1,5}' placeholder='Num. votos:' required /></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Media: </th>";
				echo"              <td><input type='text' class='form-control' name='mediaVotosWeb' value='".$linea['mediavotosweb']."' title='De 1 a 10' pattern='[0-9]{1}' placeholder='Num. votos:' required /></td>";
				echo"   </tr>";
				echo"   <tr>";
				echo "            <th>Categoria: </th>";
				echo "			  <td> ";
                          						echo dibujarLayoutCategoriasMostrandoLaCategoriaAsignada($linea['categoriaweb']);
                      			
							echo "</td>";
				echo "</tr>";
				echo"    <tr>"; 	
				echo" 		   <input type=hidden name=accion value=22></input>";	
				echo" 		   <input type=hidden name=idWeb value=".$idWeb."></input>";
				echo"          <td align=center><a href=usuariosgestionarwebs.php?accion=3&idWeb=".$linea['idWeb']." title='Borrar' class='btn btn-primary btn-large'><img src='../imagenes/borrar.png'></img>Borrar</a></td>";
				echo"          <td align=center><input type=submit value='Actualizar' class='btn btn-primary btn-large' ></td>";
				echo"    </tr>";
	
			
		}
		echo"</table>";
		$basededatos->desconectar();

		echo" </form>";
		
		
	}
		
	function confirmarBorrarWeb($idWeb){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar ".obtenerNombreWeb($idWeb)."?, es muy bonito...</h3><br /><img src=../imagenes/bonito".$foto.".jpg></img><br />";
		echo "<h1><a href='usuariosgestionarwebs.php?accion=5&idWeb=$idWeb'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='usuariosgestionarwebs.php?accion=6&idWeb=$idWeb'>NO</a></h1>";	
	}
	function borrarWeb($idWeb){
		
		
		
			$mensaje=obtenerNombreWeb($idWeb)." borrado. ";
			$bd= new mysqlusuarios();
			$bd->conectar_mysql();
			$sql="DELETE FROM webs_".$_SESSION['idusuario']." WHERE idWeb='$idWeb' LIMIT 1";
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			echo "<script type='text/javascript'>location.href='usuariosgestionarwebs.php?mensaje=$mensaje'</script>";
		
		
			
		
	}
	function redirigirPorNoBorrar($idWeb){
		$mensaje=obtenerNombreWeb($idWeb)."No borrado";
		echo "<script type='text/javascript'>location.href='usuariosgestionarwebs.php?mensaje=$mensaje'</script>";
	}
	
	function mostrarUnWeb($idWeb){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs_".$_SESSION['idusuario']." WHERE idweb='".$idWeb."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo"<table class='table table-responsive table-striped table-border table-hover' border=0 width= 500px >";
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			
				echo"  <tr> ";
				echo"              <th valign='top'>Direcci&oacute;n o URL</th>";
				echo"              <td>".$linea['nombreweb']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre web</th>";
				echo"              <td>".$linea['tituloweb']."</td>";
				echo"   </tr>";
				echo"   <tr> ";
				echo"              <th valign='top'>Descricpion:</th>";
				echo"              <td>".$linea['descripcionweb']."</td>";
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
				echo"              <td><div class='textbox'>".$linea['mediavotosweb']."</div></td>";
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
				//echo"              <td><a href=usuariosgestionarwebs.php?accion=3&idWeb=".$idWeb." title='Borrar'><img src='../imagenes/borrar.png'></img>Borrar</a></td>";
				echo"              <td colspan=2  align=center><a href=usuariosgestionarwebs.php?accion=2&idWeb=".$idWeb." title='Editar' class='btn btn-primary'><img src='../imagenes/actualizar.png' >Editar</img></a></td>";
				echo"   </tr>";
			
		}
		echo"</table>";
		$basededatos->desconectar();

		
	
	}
	
	function aplicarInsercionWeb(){
		if(obtenerTotalRegistros()>1000){
			$mensaje="Web no insertada, no puedes meter más de 20 webs.";
		echo "<script type='text/javascript'>location.href='usuariosgestionarwebs.php?mensaje=".$mensaje."';</script>";
		}else{
	
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
			//$_POST[imagen]="nada";
			$fecha=date("j/n/Y");
			$_POST['numerovotosweb']=$_POST['numerovotosweb']+1;
			$bd= new mysqlusuarios();
			$bd->conectar_mysql();
			$sql="INSERT INTO webs_".$_SESSION['idusuario']." VALUES ( '', '$nombreCortado', '$_POST[tituloWeb]','$_POST[descripcionWeb]','$fecha', '$_POST[tagsWeb]', '$_POST[numeroVotosWeb]','$_POST[mediaVotosWeb]', '0','sinimagen1.jpg','$_POST[categoriaweb]') ";
			$bd->ejecutar_sql($sql);
	
			$bd->desconectar();
			$mensaje="Web ".$nombreCortado." nueva insertada.";
			echo "<script type='text/javascript'>location.href='usuariosgestionarwebs.php?mensaje=".$mensaje."';</script>";
		}
	}
	
	
	
	function aplicarActualizacionWeb($idWeb){
		//$nombreCortado="";
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
		$bd= new mysqlusuarios();
		$bd->conectar_mysql();
		$sql="update webs_".$_SESSION['idusuario']." set nombreWeb='$nombreCortado', tituloweb='$_POST[tituloWeb]', descripcionweb='$_POST[descripcionWeb]', fechaweb='$_POST[fechaWeb]', tagsweb='$_POST[tagsWeb]', numerovotosweb='$_POST[numeroVotosWeb]', mediavotosweb='$_POST[mediaVotosWeb]', contadorweb='$_POST[contadorWeb]', imagenweb='sinimagen1.jpg', categoriaweb='$_POST[categoriaweb]' where idweb='$idWeb'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Web ".obtenerNombreWeb($idWeb)." actualizado.";
		echo "<script type='text/javascript'>location.href='usuariosgestionarwebs.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	
	
	
	
/***************************Main*********************************************/
	include("usuariosdibujarhtml.php");
	require('../mysqlusuarios.php');
	require('../Web.php');
	dibujarhtmlUsuarios();

	if (isset($_GET['mensaje'])) echo "<br /><span style='color:red'>".$_GET['mensaje']."</span>";
	
	
	if (!isset($_GET['accion']) && $_POST['accion']<40 && $_POST['accion']!=12 ){
		echo"<p>Llevas: ".obtenerTotalRegistros()."</p>";
		dibujarWebs();
	}else{
		if ($_GET['accion']==1){
			crearNuevoWeb();
		}else if($_GET['accion']==2){
			actualizarWeb($_GET['idWeb']);
		}else if($_GET['accion']==3){
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
			aplicarInsercionWeb($_POST);
	}else if($_POST['accion'] == 22){
			aplicarActualizacionWeb($_POST['idWeb'], $_POST);
	}
/****************************************************************************/








	
dibujarPaginaAbajoUsuarios();
?>

