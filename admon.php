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

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Registro Individual Curso</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Ir a la ultima peticion <span class="sr-only">(current)</span></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



<?php
	//Manipulacion de Archivos Excel con el listado de estudiantes
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
		<table>
				<tr>					
				<thead>INSERCION DATOS </thead>
				</tr>
				<tr>
					<td>
				<input type="text" placeholder="PENSUM" name="pensum" requerid autofocus>
				<input type="text" placeholder="AÑO" name="anio" requerid autofocus>
				<input type="text" placeholder="PLAN" name="plancarrera">
				<input type="text" placeholder="CICLO" name="ciclocarrera" requerid autofocus>
				<input type="text" placeholder="CURSO" name="nombremateria">
				<input type="text" placeholder="CODIGO CURSO" name="codigomateria">
				<input type="text" placeholder="CATEDRATICO" name="catedratico" requerid autofocus>
				<input type="text" placeholder="CODIGO CATEDRATICO" name="codecat">
				<input type="text" placeholder="AÑO CATEDRATICO" name="aniocat">		
		
		<input type="submit" name="confir" value="+"/>
		</td>
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
		$conex4= @mysql_connect($servidor,$usuario,$pass)or die("Problema al conectar el servidor");
		mysql_select_db($db_name);
		$conex5= @mysql_connect($servidor,$usuario,$pass)or die("Problema al conectar el servidor");
		mysql_select_db($db_name);
		$reg= @mysql_connect($servidor,$usuario,$pass)or die("Problema al conectar el servidor");
		mysql_select_db($db_name);
			@mysql_query("INSERT INTO Pensum(anio) VALUES ('$_POST[pensum]')",$conex2);
				$maxpensumi = mysql_query("SELECT MAX(idPensum) FROM Pensum");
				if ($row = mysql_fetch_row($maxpensumi)) {
			//'¿ funcion id pensum para ir armando la subtabla, en proceso deberia ser +'
				$ultimopensumid = trim($row[0]);
					}
			@mysql_query("INSERT INTO Cursos(idMateria,nombreMateria) VALUES ('$_POST[codigomateria]','$_POST[nombremateria]')",$conex);
			@mysql_query("INSERT INTO Cursos_Pensum(Cursos_idMateria,Pensum_idPensum) VALUES ('$_POST[codigomateria]','$ultimopensumid')",$conex4);
			@mysql_query("INSERT INTO docentes(nombresDocente,direccionDocente) VALUES ('$_POST[catedratico]','$_POST[codecat]')",$conex3);
			
			//primera consulta IDPENSUM
			
			$maxcid = mysql_query("SELECT MAX(idDocente) FROM Docentes");
				if ($row = mysql_fetch_row($maxcid)) {
					//maxcid ultimo id ingresado catedra
			//'¿ funcion id pensum para ir armando la subtabla, en proceso deberia ser +'
				$mascid = trim($row[0]);
			}
				$maxcidtablaf = mysql_query("SELECT MAX(idCurso_Pensum) FROM Cursos_Pensum");
				if ($row = mysql_fetch_row($maxcidtablaf)) {
					//maxcid ultimo id ingresado catedra
			//'¿ funcion id pensum para ir armando la subtabla, en proceso deberia ser +'
				$mascidtable = trim($row[0]);
			//RELLENO LA TABLA REL FUERTE
			}
			@mysql_query("INSERT INTO cursos_semestres(Ciclo,plan,anio,Docentes_IdDocente,Cursos_Pensum_idCurso_pensum) VALUES ('$_POST[ciclocarrera]','$_POST[plancarrera]','$_POST[anio]','$mascid','$mascidtable')",$reg);
			}
?>


							

			<tr>	
			<td>
				 
			</td>
			</tr>
	</table>
	</form>
</div>	
<!--FIN INFORMACION DOCENCIA
		
		 -->


	
	<?php
	include("conexion.php");
/*	
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
*/
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
			//muestra el ultimo id del listado de estudiantes
			//echo $ultimoid;
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
		    $agregar= @mysql_query("INSERT INTO estudiantes(carnet,nombresEstudiante,paswordEstudiante) VALUES('$carnetalumno','$nombrealumno','$carnetalumno')");
			
			//consulta de los ids ingresados
			//$consulta=@mysql_query(query)
			
		
			//$relacional1=@mysql_query("INSERT INTO Estudiantes_de_cursos(Estudiantes_idEstudiantes,Cursos_semestres_idCurso_semestre) VALUES('$idEstudiante'],'$idRelacional')");
			
		
			
			}
			}
			//consulta
			$query = "SELECT idEstudiante FROM estudiantes where idEstudiante>'$ultimoid'";
      		$result = mysql_query($query);
      		$i=0;
      		//relacion cursos para almancenar a los estudiantes segun catedratico,semestre,curso etc tabla importante
			$rsult2 = mysql_query("SELECT MAX(idCurso_semestre) FROM Cursos_semestres");
			if ($row = mysql_fetch_row($rsult2)) {
			$tablad = trim($row[0]);
			//$relacioncursos=$tablad;
			}

      		
      		$tamano=0;
      			while ($row = mysql_fetch_array($result)){        
      					//la linea de abajo muestra los id asignados
      					//echo '<br>',$row['idEstudiante']; 
      					//asignar un nuevo arreglo para guardarlo
      					$idcopiaestudiante[$i]=$row['idEstudiante'];
      					$i++;
      					//se almacenara en la tabla intermedia
      					$tamano++;    
      				}

      				for($i=0 ; $i<$tamano; $i++){
      			    $valor=$idcopiaestudiante[$i];
      			    //el echo de abajo asigna al conjunto de estudiantes por lotes
      			    //echo $valor;
					$insertarrelacion=@mysql_query("INSERT INTO estudiantes_de_cursos(Estudiantes_idEstudiante,Cursos_semestres_idCurso_semestre)VALUES('$valor','$tablad')");

					}
      				echo "datos almacenados"
					
      					
								
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
<div class="container" id="passw">
<!-- <input type="submit" name="btnupdate" class="btn" id="button1" value="Asignar y Grabar contraseñas al Listado Anterior">	-->

</div>
	<script type="js/jquery-1.11.2.min.js"></script>
	<script type="js/bootstrap.js"></script>
</body>
</html>