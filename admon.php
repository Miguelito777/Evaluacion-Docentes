<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Administrador</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">

</head>
<body id="bodyadmon">

<div class="container-fluid well" id="encabezado">
	<div class="row">
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2	 ">
	<img src="logo.png" class="img-responsive" id="log1">
	</div> 	
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 visible-xs visible-sm visible-md visible-lg">Conocereis la verdad y la verdad os hara libres</div>
	</div>
</div>




<?php
	if(isset($_POST['radio'])){
		//subir la copia temporal del archivo
		$nameEXCEL = @$_FILES['archivo']['name'];
		$tmpEXCEL = @$_FILES['archivo']['tmp_name'];
		$extEXCEL = pathinfo($nameEXCEL);
		$urlnueva = "xls/aalumno.xls";			
		if(is_uploaded_file($tmpEXCEL)){
			copy($tmpEXCEL,$urlnueva);	
			
		}
		
	}
?>



<!--DOCENCIA INFORMACION 
		
		 -->
	<div class="continer well">
	<form action="admon.php" method="POST" enctype="multipart/form-data" name="form">
							
			<thead>INSERCION DATOS </thead>
			 		<tr> 
			<td>
			
				<input type="text" placeholder="PENSUM" name="pensum" requerid autofocus>
			</td>	
			<td>
			
				<input type="text" placeholder="CURSO" name="nombremateria">
			</td>
			<td>
				<input type="text" placeholder="Codigo Curso" name="codigomateria">
		    </td>
		</tr>
			<tr> 
			<td>
			
				<input type="text" placeholder="Catedratico" name="catedratico" requerid autofocus>
			</td>	
			<td>
			
				<input type="text" placeholder="Codigo Catedratico" name="codecat">
			</td>
		</tr>
		 <tr>
		<input type="submit" name="confir" value="+"/>
	</tr>
<?php
include("conexion.php");
	//Insert Pensum y curso
	

	//Insert inf docent
		if(isset($_POST['catedratico']) && !empty($_POST['codecat'])){
		
		$conex= @mysql_connect($servidor,$usuario,$pass)or die("Problema al conectar el servidor");
		mysql_select_db($db_name);
		$conex2= @mysql_connect($servidor,$usuario,$pass)or die("Problema al conectar el servidor");
		mysql_select_db($db_name);
		$conex3= @mysql_connect($servidor,$usuario,$pass)or die("Problema al conectar el servidor");
		mysql_select_db($db_name);
			@mysql_query("INSERT INTO Pensum(anio) VALUES ('$_POST[pensum]')",$conex2);
			@mysql_query("INSERT INTO Cursos(idMateria,nombreMateria) VALUES ('$_POST[codigomateria]','$_POST[nombremateria]')",$conex);
			@mysql_query("INSERT INTO docentes(nombresDocente,direccionDocente) VALUES ('$_POST[catedratico]','$_POST[codecat]')",$conex3);
			@mysql_query("INSERT INTO Cursos_Pensum(direccionDocente) VALUES ('$_POST[catedratico]','$_POST[codecat]')",$conex3);
			}
?>

	</form>
</div>
<!--FIN DOCENCIA
		 -->
<div class="container well">
<form action="admon.php" method="POST" enctype="multipart/form-data" name="form">
							
			<thead>INSERCION DATOS </thead>
			 	
			<tr>	
			<td>
			
				<input type="text" placeholder="Plan" name="plancarrera" requerid autofocus>
				
			</tr>
			<tr>
			
				<input type="text" placeholder="Ciclo" name="ciclocarrera" requerid autofocus>
				<input type="text" placeholder="Año" name="anio" requerid autofocus>
				<input type="text" placeholder="IdDocente" name="iddocente" requerid autofocus>
			</tr>

		 <tr>
		<input type="submit" name="confir" value="+"/>
	</tr>
<?php
include("conexion.php");
	if(isset($_POST['ciclocarrera']) && !empty ($_POST['ciclocarrera']) && !empty($_POST['plancarrera'])&& !empty($_POST['anio'])){
		$reg= @mysql_connect($servidor,$usuario,$pass)or die("Problema al conectar el servidor");
		mysql_select_db($db_name);
			@mysql_query("INSERT INTO cursos_semestres(Ciclo,plan,anio,Docentes_IdDocente) VALUES ('$_POST[ciclocarrera]','$_POST[plancarrera]','$_POST[anio]','$_POST[iddocente]')",$reg);
			}
?>

	</form>
</div>	
<!--FIN INFORMACION DOCENCIA
		
		 -->

<div class="container well">
<form action="admon.php" method="POST" enctype="multipart/form-data" name="form">
							
			<thead>TOMAR EL ID DE LA TABLA CURSOS SEMESTRES Y LOS ID DE LOS ALUMNOS Y ASIGNARLOS A LA TABLA ESTUDIANTES_DE_CURSOS </thead>
			 	
			<tr>	
			<td>
			
				<input type="text" placeholder="Plan" name="plancarrera" requerid autofocus>
		

		 <tr>
		<input type="submit" name="confir" value="+"/>
	</tr>
<?php
include("conexion.php");
	if(isset($_POST['ciclocarrera']) && !empty ($_POST['ciclocarrera']) && !empty($_POST['plancarrera'])&& !empty($_POST['anio'])){
		$reg= @mysql_connect($servidor,$usuario,$pass)or die("Problema al conectar el servidor");
		mysql_select_db($db_name);
			@mysql_query("INSERT INTO cursos_semestres(Ciclo,plan,anio,Docentes_IdDocente) VALUES ('$_POST[ciclocarrera]','$_POST[plancarrera]','$_POST[anio]','$_POST[iddocente]')",$reg);
			}
?>

	</form>
</div>	

	
	<?php
	include("conexion.php");
	
	$query = "SELECT * FROM docentes";
      		$result = mysql_query($query);
					
		 	   echo "<table border='2'>";      
		     echo "<tr>";     
		     echo "<th>ID</TH><th>Nombre</TH><TH>Codigo</th>";      
		     echo "</tr>";
      			while ($row = mysql_fetch_array($result)){        
      					echo "<TR>";        
      					echo "<td>",$row['idDocente'], "</td><td>", $row['nombresDocente'], "</td><td>", $row['direccionDocente'], "</td>";        echo "</tr>";     $idrevisa='idEstudiante'; }
      					echo "</TABLE>";	
					
      						$rs = mysql_query("SELECT MAX(idDocente) FROM docentes");
							if ($row = mysql_fetch_row($rs)) {
							$id = trim($row[0]);
							echo $id;
							
							}	

$query2 = "SELECT * FROM cursos_semestres";
      		$result2 = mysql_query($query2);
					
		 	   echo "<table border='2'>";      
		     echo "<tr>";     
		     echo "<th>ID</TH><th>Nombre</TH><TH>Codigo</th>";      
		     echo "</tr>";
      			while ($row = mysql_fetch_array($result)){        
      					echo "<TR>";        
      					echo "<td>",$row['idCursoSemestre'], "</td><td>", $row['Plan'], "</td><td>", $row['anio'], "</td>";        echo "</tr>";     $idrevisa='idEstudiante'; }
      					echo "</TABLE>";	
	?>




<div class="container well" id="barrasub">
<form action="" method="post" enctype="multipart/form-data" name="form2">
<table width="100%" border="0">
  <tr>
    <td>
      <strong>Agregar Archivo de Excel</strong>
      
      <input type="file" name="archivo" id="archivo">
      
      </td>
      <td>
      <label><input type="radio" name="radio" value="s" />SI</label>
      <label><input type="radio" name="radio" value="n" checked/>NO</label>
      
<input type="submit" name="btnupdate" class="btn" id="button1" value="Actualizar">
<input type="submit" name="btnConfirmar" class="btn" id="button3" value="Grabar">

    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>
</div>
<div class="container" id="listado">
<table border="1" width="100%" id="Tabla_Generada">
	<thead>
    	<tr>
        	<th><center><strong>CARNET</strong></center></th>
            <th><center><strong>NOMBRE</strong></center></th>
    
        </tr>
	</thead>
    <tbody>

<?php
include('conexion.php');
			$rs = mysql_query("SELECT MAX(idEstudiante) FROM estudiantes");
			if ($row = mysql_fetch_row($rs)) {
			$ultimoid = trim($row[0]);
			echo $ultimoid;
			}
							

		if(isset($_POST['btnupdate'])){
		
			require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
			
			$objPHPExcel = PHPExcel_IOFactory::load('xls/aalumno.xls');
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			foreach ($objHoja as $iIndice=>$objCelda) {
	
						echo '
							<tr>
								<td>'.$objCelda['B'].'</td>
								<td>'.$objCelda['C'].'</td>
								
							</tr>
						';
		   
		    $carnetalumno=$objCelda['B'];
		    $nombrealumno=$objCelda['C'];
		    $agregar= @mysql_query("INSERT INTO estudiantes(carnet,nombresEstudiante) VALUES('$carnetalumno','$nombrealumno')");
			
			//consulta de los ids ingresados
			//$consulta=@mysql_query(query)
			
		
			//$relacional1=@mysql_query("INSERT INTO Estudiantes_de_cursos(Estudiantes_idEstudiantes,Cursos_semestres_idCurso_semestre) VALUES('$idEstudiante'],'$idRelacional')");
			
		
			
			}
			}
			//consulta
			$query = "SELECT idEstudiante FROM estudiantes where idEstudiante>'$ultimoid'";
      		$result = mysql_query($query);
      		$i=0;
      		$relacioncursos="3";
      		$tamano=0;
      			while ($row = mysql_fetch_array($result)){        
      					echo '<br>',$row['idEstudiante']; 
      					//asignar un nuevo arreglo para guardarlo
      					$idcopiaestudiante[$i]=$row['idEstudiante'];
      					$i++;
      					//se almacenara en la tabla intermedia
      					$tamano++;    
      				}

      				for($i=0 ; $i<$tamano; $i++){
      			    $valor=$idcopiaestudiante[$i];
      			    echo $valor;
					$insertarrelacion=@mysql_query("INSERT INTO estudiantes_de_cursos(Estudiantes_idEstudiante,Cursos_semestres_idCurso_semestre)VALUES('$valor','$relacioncursos')");
					}
      				
					
      					
								
			//RECIBO LAS VARIABLES RELACIONADAS Y HAGO LO SIGUIENTE
			//&CONDICION1REL = -¡ INSERT INTO TABLARELACION(CAMPO) VALORES(VARIABLES INTERVIENEN RECIBIDAS)
	
			//$insercionrel= @mysql_query("INSERT INTO Estudiantes_de_curso($carnetalumno)VALUES()");
					//INSERTAR TODO
					//CADA QUE EL BOTON ENVIAR 
		
			//TODO SIGNIFICA 

						

			
	?>   
    </tbody>
</table>	
</div>
	<script type="js/jquery-1.11.2.min.js"></script>
	<script type="js/bootstrap.js"></script>
</body>
</html>