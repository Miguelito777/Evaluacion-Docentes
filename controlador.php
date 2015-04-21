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
		
		$_SESSION["preguntas"] = $preguntasarray;
		$_SESSION["i"] = 0;
		//$preguntasobject = (Object)$preguntasarray;
		//echo json_encode($preguntasobject);
		echo true;
		//echo $_SESSION["preguntas"][0][1]; 
	}
	if (isset($_POST["preguntaactual"])) {
		$i = $_SESSION["i"];
		$pregunta = array(); 
		$pregunta[0][0] = $_SESSION["preguntas"][$i][0];
		$pregunta[0][1] = $_SESSION["preguntas"][$i][1];
		$respuestas = new Respuestas();
		$respuestas->buscar($pregunta[0][0]);
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
		
		for ($i=0; $i < count($respuestasarray); $i++) { 
			$pregunta[1][$i] = $respuestasarray[$i][0];
		}
		for ($i=0; $i < count($respuestasarray); $i++) { 
			$pregunta[2][$i] = $respuestasarray[$i][1];
		}
		$i++;
		$_SESSION["i"] = $i;
		$respuesta_object = (Object)$pregunta;
		echo json_encode($respuesta_object);
		
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

	if(isset($_POST["idpregunta"]) && isset($_POST["idrespuesta"])){
		echo "hola mundotp";
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

	if (isset($_POST["pregunta"])) {
		$almacenar = new Almacenar();
		if(!$almacenar->pregunta($_POST["pregunta"]))
			echo "Error al almacenar el pensum";
		else
			echo "Pensum almacenado correctamente";
	}

	if (isset($_POST["respuesta"])) {
		$almacenar = new Almacenar();
		if(!$almacenar->respuesta($_POST["respuesta"]))
			echo "Error al almacenar el pensum";
		else
			echo "PRespuesta almacenado correctamente";
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

	if (isset($_POST["verpreguntas"])) {
		$consulta = new Consultas();
		$consulta->preguntas();
		$i = 0;
		$preguntas_array = array();
		while ($pregunta = $consulta->obtenerPregunta()) {
			$j = 0;
			foreach ($pregunta as $key => $value) {
				$preguntas_array[$i][$j] = $value;
				$j++;
			}
			$i++;
		}
		$preguntas_object = (Object)$preguntas_array;
		echo json_encode($preguntas_object);
	}

	if (isset($_POST["verrespuestas"])) {
		$respuestas = new Respuestas();
		$respuestas->buscarTodos();
		$i = 0;
		$respuestas_array = array();
		while ($pregunta = $respuestas->obtener()) {
			$j = 0;
			foreach ($pregunta as $key => $value) {
				$respuestas_array[$i][$j] = $value;
				$j++;
			}
			$i++;
		}
		$preguntas_object = (Object)$respuestas_array;
		echo json_encode($preguntas_object);
	}

	if (isset($_POST["idpensum"]) && isset($_POST["nombrepensum"])) {
		$_SESSION["idpensum"] = $_POST["idpensum"];
		$_SESSION["nombrepensum"] = $_POST["nombrepensum"];
		$datospensum = true;
		echo "$datospensum";
	}

	if (isset($_POST["consultarcursos"])){
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
	if (isset($_POST["consultarcursospensumactual"])) {
		$consulta = new Consultas();
		$consulta->cursosActuales();
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

	if (isset($_POST["pensum_curso"])) {
		$pensum_cursos = json_decode($_POST["pensum_curso"]);
		$pensumcursos = new Almacenar();
		$i = 0;
		foreach ($pensum_cursos as $key) {
			$j = 0;
			$pensumcursosarray[$i][$j] = $key->idcurso;
			$j++;
			$pensumcursosarray[$i][$j] = $key->idpensum;
			$i++;	
		}
		
		for ($i=0; $i < count($pensumcursosarray); $i++) { 
			if(!$pensumcursos->pensumCursos($pensumcursosarray[$i][0],$pensumcursosarray[$i][1])){
				die("Eror al almacenar los cursos "+mysql_error());
				break;
			}		
		}
		echo true;	
	}

	if (isset($_POST["preguntas_seleccionadas"]) && isset($_POST["respuestas_seleccionadas"])) {
		$preguntas = $_POST["preguntas_seleccionadas"];
		$respuestas = $_POST["respuestas_seleccionadas"];
		$almacenar = new Almacenar();

		for ($i=0; $i < count($preguntas); $i++) { 
			for ($j=0; $j < count($respuestas); $j++) { 
				$almacenar->preguntasRespuestas($preguntas[$i],$respuestas[$j]);
			}
		}

		echo true;
	}

	if (isset($_POST["cursos_seleccionados"]) && isset($_POST["preguntas_seleccionadas"])) {
		$cursos = $_POST["cursos_seleccionados"];
		$preguntas = $_POST["preguntas_seleccionadas"];
		$almacenar = new Almacenar();

		for ($i=0; $i < count($cursos); $i++) { 
			for ($j=0; $j < count($preguntas); $j++) { 
				$almacenar->CursosPreguntas($cursos[$i],$preguntas[$j]);
			}
		}
		echo true;
	}
?>