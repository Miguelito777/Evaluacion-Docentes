<?php
	session_start();
	include 'modelo.php';

	if (isset($_POST["usuario"]) && isset($_POST["password"])) {
		$login = new Log_in($_POST["usuario"],$_POST["password"]);

		if($login->is_docente())
			echo "docente";
		elseif ($login->is_estudiante())
			echo "estudiante";
		else
			echo "noregistrado";
	}

	if (isset($_GET['solicitarcursos'])) {
		$cursos = new Cursos($_SESSION['idEstudiante']);
		$cursos->buscar();
		$i = 0;
		$cursosarray = array(); 
		while ($cursocontrolador = $cursos->obtener()) {
			$j = 0;
			foreach ($cursocontrolador as $key => $value) {
				$cursosarray[$i][$j] = $value;
				$j++;
			}
			$i++;
		}
		$cursos_object = (Object)$cursosarray;
		echo json_encode($cursos_object);
	}

	if (isset($_POST["preguntas"])) {
		$preguntas = new Preguntas();
		$preguntas->solicitar($_POST["preguntas"]);
		$i = 0;
		$preguntasarray = array();
		while ($pregunta = $preguntas->obtener()){
			$j = 0;
			foreach ($pregunta as $key => $value) {
				$preguntasarray[$i][$j] = $value;
				$j++;
			}
			$i++;
		}
		$preguntasobject = (Object)$preguntasarray;
		echo json_encode($preguntasobject);
	}

	if (isset($_POST["idpregunta"])) {
		$respuestas = new Respuestas();
		$respuestas->buscar($_POST["idpregunta"]);
		$i = 0;
		$respuestasarray = array();
		while ($respuesta = $respuestas->obtener()){
			$j = 0;
			foreach ($respuesta as $key => $value) {
				$respuestasarray[$i][$j] = $value;
				$j++;
			}
			$i++;
		}
		$respuestas_object = (Object)$respuestasarray;
		echo json_encode($respuestas_object);
	}

	if (isset($_POST["idcurso"]) && isset($_POST["nombrecurso"])) {
		$almacenar = new Almacenar();
		if(!$almacenar->curso($_POST["idcurso"],$_POST["nombrecurso"]))
			echo "Error al almacenar el curso";
		else
			echo "Curso almacenado correctamente";
	
	}

	if (isset($_POST["pensum"])) {
		$almacenar = new Almacenar();
		if(!$almacenar->pensum($_POST["pensum"]))
			echo "Error al almacenar el pensum";
		else
			echo "Pensum almacenado correctamente";
	}

	if (isset($_POST["verpensums"])) {
		$consulta = new Consultas();
		$consulta->pensum();
		$i = 0;
		$pensum_array = array();
		while ($pensum = $consulta->obtenerPensum()) {
			$j = 0;
			foreach ($pensum as $key => $value) {
				$pensum_array[$i][$j] = $value;
				$j++;
			}
			$i++;
		}
		$pensum_object = (Object)$pensum_array;
		echo json_encode($pensum_object);
	}

	if (isset($_POST["idpensum"]) && isset($_POST["nombrepensum"])) {
		$_SESSION["idpensum"] = $_POST["idpensum"];
		$_SESSION["nombrepensum"] = $_POST["nombrepensum"];
		$datospensum = true;
		echo "$datospensum";
	}

	if (isset($_POST["consultarcursos"])) {
		$consulta = new Consultas();
		$consulta->cursos();
		$i = 0;
		$cursos_array = array();
		while ($curso = $consulta->obtenerCruso()) {
			$j = 0;
			foreach ($curso as $key => $value) {
				$cursos_array[$i][$j] = $value;
				$j++;
			}
			$i++;
		}
		$cursos_object = (Object)$cursos_array;
		echo json_encode($cursos_object);
	}
	if (isset($_POST["traerpensum"])) {
		$pensum_array = array();
		$pensum_array[0] = $_SESSION["idpensum"];
		$pensum_array[1] = $_SESSION["nombrepensum"];
		//echo $pensum_array[1];
		$pensum_object = (Object)$pensum_array;
		echo json_encode($pensum_object);
	}
?>