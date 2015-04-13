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
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="colapse" data-target=".navbar-ex1-collapse"></button>
		<span>Bienvenido @</span>
		<span></span>
		<span></span>
		</button>
		
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li><a href="suite.php">ADMINISTRAR</a></li>
				<li><a href="evento.php">SERVICIOS</a></li>
				<li><a href="admon.php">ASIGNACION LISTADO</a></li>
				<li><a href="index.php">SALIR</a></li>
			</ul>
		</div>


	</div>
</nav>
<div align="center">

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
</div>
	
	<form action="admon.php" method="POST" enctype="multipart/form-data" name="form1">
			<div class="container-fluid well" id="ingreso-general">
			<thead></thead>
			<tr>	
			<td>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 visible-xs visible-sm visible-md visible-lg push 1" class="form-group">
				<input type="text" class="form" placeholder="Plan" name="plancarrera" requerid autofocus>
			</div>			
			</tr>
			<tr>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 visible-xs visible-sm visible-md visible-lg" class="form-group">
				<input type="text" class="form" placeholder="Ciclo" name="ciclocarrera" requerid autofocus>
			</div>		
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 visible-xs visible-sm visible-md visible-lg push-1"class="form-group">
				<input type="text" class="form" placeholder="Semestre" name="semestre" requerid>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 visible-xs visible-sm visible-md visible-lg push 1" class="form-group">
				<input type="text" class="form" placeholder="Año" name="anio" requerid autofocus>
			</div>	
			</td>	
			<td>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 visible-xs visible-sm visible-md visible-lg push 1" class="form-group">
				<input type="text" class="form" placeholder="Catedratico" name="catedratico" requerid autofocus>
			</div>		
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 visible-xs visible-sm visible-md visible-lg" 	class="form-group">
				<input type="text" class="form" placeholder="Codigo Catedratico" name="codecat" requerid>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 visible-xs visible-sm visible-md visible-lg" 	class="form-group">
				
			</div>

		</tr>
		<!--BOTON PARA ENVIAR LA CABECERA A SUS RESPECTIVAS TABLAS
			SEGUN
		
		 -->

		<input type="submit" name="confir" value="Confirmar datos">

	</div>
	</form>
	<?php 
		include('conexion.php');
		//$insercionsicat= @mysql_query("INSERT INTO Docentes(nombreDocente, direccionDocente) VALUES('catedratico','codecat')");
			 if (isset($_POST['confir'])) {
			 	$plancarrera=$_POST['plancarrera'];
			 	$ciclocarrera=$_POST['ciclocarrera'];
			 	$semestre=$_POST['semestre'];
			 	$aniocarrera=$_POST['anio'];
			 	$catedratico=$_POST['catedratico'];
			 	$codigocatedra=$_POST['codecat'];
			//$insersionrelacion=@mysql_query("INSERT INTO Estudiantes_de_cursos(Estudiantes_idEstudiantes,Cursos_semestres_idCurso_semestre)");
	
			$insercionsimple= @mysql_query("INSERT INTO cursos_semestres(plan, Ciclo, anio) VALUES('$plancarrera','$ciclocarrera','$aniocarrera')");

			echo "se insertaron los datos";
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
      
<input type="submit" name="button" class="btn" id="button" value="Actualizar">

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
		if(isset($_POST['radio'])){
		
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
			
			

			//RECIBO LAS VARIABLES RELACIONADAS Y HAGO LO SIGUIENTE
			//&CONDICION1REL = -¡ INSERT INTO TABLARELACION(CAMPO) VALORES(VARIABLES INTERVIENEN RECIBIDAS)
	
			//$insercionrel= @mysql_query("INSERT INTO Estudiantes_de_curso($carnetalumno)VALUES()");
					//INSERTAR TODO
					//CADA QUE EL BOTON ENVIAR 
		}
			//TODO SIGNIFICA 

						

			}
	?>   
    </tbody>
</table>	
</div>
	<script type="js/jquery-1.11.2.min.js"></script>
	<script type="js/bootstrap.js"></script>
</body>
</html>