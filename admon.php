<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Administrador</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

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
			@copy($tmpEXCEL,$urlnueva);	
			
		}
		
	}
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
			$rs = mysql_query("SELECT MAX(idEstudiante) FROM Estudiantes");
			if ($row = @mysql_fetch_row($rs)) {
			$ultimoid = trim($row[0]);
			//MOSTRAR EL ULTIMO ID ASIGNADO AL ULTIMO ESTUDIANTE DEL LISTADO
			//echo $ultimoid;
			}
							

		if(isset($_POST['btnupdate'])){
		
			require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
			
			$objPHPExcel = @PHPExcel_IOFactory::load('xls/aalumno.xls');
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
							$res = mysql_query("SELECT MAX(idCurso_semestre) FROM Cursos_semestres");
							if ($row = mysql_fetch_row($res)) {
							//Esta variable va a contener el ultimo id de la tabla relacion mas fuerte
							$tablafuerte = trim($row[0]);
							
							}
			$query = "SELECT idEstudiante FROM Estudiantes where idEstudiante>'$ultimoid'";
      		$result = mysql_query($query);
      		$i=0;			
      		$tamano=0;
      			/* MOSTRAR VALORES DEL VEV[]
      			while ($row = mysql_fetch_array($result)){        
      					echo '<br>',$row['idEstudiante']; 
      					//asignar un nuevo arreglo para guardarlo
      					$idcopiaestudiante[$i]=$row['idEstudiante'];
      					$i++;
      					//se almacenara en la tabla intermedia
      					$tamano++;    
      				}
				*/
      				for($i=0 ; $i<$tamano; $i++){
      			    $valor=$idcopiaestudiante[$i];
      			    echo $valor;
					$insertarrelacion=@mysql_query("INSERT INTO estudiantes_de_cursos(Estudiantes_idEstudiante,Cursos_semestres_idCurso_semestre)VALUES('$valor','$tablafuerte')");
					}
			
	?>   
    </tbody>
</table>	
</div>	
	<script type="js/jquery-1.11.2.min.js"></script>
	<script type="js/bootstrap.js"></script>
</body>
</html>
