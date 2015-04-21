<?php
	@session_start();
/**
* Clase que realiza y finaliza una conexion
*/
class Conexion
{
	public $host = "localhost";
	public $user = "root";
	public $password = "Jesus8";
	public $database = "Evaluacion_Docente2";
	public $enlace;
	function __construct()
	{
		$this->enlace = mysql_connect($this->host,$this->user,$this->password);
		if (!$this->enlace) {
			die("Error en la conexion general: ".mysql_error());
		}
		if (!$database = mysql_select_db($this->database,$this->enlace)) {
			return false;
		}
		return true;
	}
	function closeconnect(){
		mysql_close($this->enlace);
	}
}

/**
* Clase para probar la conexion
*/
class Log_in extends Conexion
{
	public $usuario;
	public $passwordd;
	public $datosusuario;
	function __construct($usuario, $passwordd)
	{
		$this->usuario = $usuario;
		$this->passwordd = $passwordd;
	}
	function is_docente(){
		$query = "SELECT idDocente, paswordDocente, nombresDocente from Docentes where paswordDocente = '$this->passwordd' and  nombresDocente = '$this->usuario'";	
		if (!parent:: __construct()) {
			die("Error el la conexion de localizacion de docente: "+mysql_error());
		}
		if(!$this->datosusuario = mysql_query($query))
			die("Error el la consulta para localizacion del docente "+mysql_error());
		$this->closeconnect();
		if(mysql_num_rows($this->datosusuario) > 0){
			$idSessionDocente = mysql_fetch_array($this->datosusuario,MYSQL_ASSOC);
			$_SESSION["idDocente"] = $idSessionDocente['idDocente']; 
			return true;
		}
		else
			return false;	
	}
	function is_estudiante(){
		$query = "SELECT idEstudiante, nombresEstudiante from Estudiantes where paswordEstudiante = '$this->passwordd' and nombresEstudiante = '$this->usuario'";
		if (!parent:: __construct())
			die ("Error en la conexion para buscar a un estudiante"+mysql_error());
		if(!$this->datosusuario = mysql_query($query))
			die("Error en la consulta para evaluar a un estudiante"+mysql_error());
		$this->closeconnect();
		if(mysql_num_rows($this->datosusuario)>0){
			$idSessionEstudiante = mysql_fetch_array($this->datosusuario,MYSQL_ASSOC);
			$_SESSION["idEstudiante"] = $idSessionEstudiante['idEstudiante'];
			return true;	
		}
			
		else
			return false;
	}	
}

/**
* Clase que manipula los cursos de los estudiantes
*/
class Cursos extends Conexion
{
	public $idestudiante;
	public $cursos;
	function __construct($idestudiante)
	{
		$this->idestudiante = $idestudiante;
	}

	function buscar(){
		$query = "select M.nombreMateria, CS.idCurso_semestre, CS.Docentes_idDocente from Cursos M  inner join Cursos_Pensum CP on M.idMateria = CP.Cursos_idMateria inner join Cursos_semestres CS on CP.idCurso_pensum = CS.Cursos_Pensum_idCurso_pensum inner join Estudiantes_de_cursos EC on CS.idCurso_semestre = EC.Cursos_semestres_idCurso_semestre and EC.Estudiantes_idEstudiante = $this->idestudiante";
		if(!parent:: __construct())
			die ("Error al realizar la conexion en los cursos "+mysql_error());
		if(!$this->cursos = mysql_query($query))
			die("Error al consutlar los curos: "+mysql_error());
		$this->closeconnect();
	}

	function obtener(){
		if($cursomodelo = mysql_fetch_array($this->cursos,MYSQL_ASSOC))
			return $cursomodelo;
		else
			return false;
	}
}

/**
* Clase que almacena datos
*/
class Almacenar extends Conexion
{
	function __construct()
	{
	}

	function curso($idcurso,$nombrecurso){
		$query = "INSERT into Cursos(idMateria, nombreMateria) values ('$idcurso','$nombrecurso'	)";
		if (!parent:: __construct()) 
			die("Eror en la conexion para almacenar los cursos "+mysql_error());
		if (!$almacenar = mysql_query($query)) {
			die("Error al almacenar los cursos"+mysql_error());
			return false;
		}
		$this->closeconnect();
		return true;
	}
	function pensum($pensum){
		$query = "INSERT into Pensum(anio) values ('$pensum')";
		if (!parent:: __construct()) 
			die("Eror en la conexion para almacenar los pensum "+mysql_error());
		if (!$almacenar = mysql_query($query)) {
			die("Error al almacenar los pensum "+mysql_error());
			return false;
		}
		$this->closeconnect();
		return true;
	}

	function pregunta($pregunta){
		$query = "INSERT into Preguntas(Pregunta) values ('$pregunta')";
		if (!parent:: __construct()) 
			die("Eror en la conexion para almacenar los pensum "+mysql_error());
		if (!$almacenar = mysql_query($query)) {
			die("Error al almacenar los pensum "+mysql_error());
			return false;
		}
		$this->closeconnect();
		return true;
	}

	function respuesta($respuesta){
		$query = "INSERT into Respuestas (Respuestascol) values ('$respuesta')";
		if (!parent:: __construct()) 
			die("Eror en la conexion para almacenar los pensum "+mysql_error());
		if (!$almacenar = mysql_query($query)) {
			die("Error al almacenar los pensum "+mysql_error());
			return false;
		}
		$this->closeconnect();
		return true;
	}

	function pensumCursos($idcurso,$idpensum){
		$idpensumint = (int)$idpensum;
		$query = "INSERT into Cursos_Pensum (Cursos_idMateria,Pensum_idPensum) values ('$idcurso',$idpensumint)";
		if (!parent:: __construct()) 
			die("Eror en la conexion para almacenar los pensum "+mysql_error());
		if (!$almacenar = mysql_query($query)) {
			die("Error al almacenar los pensum "+mysql_error());
			return false;
		}
		$this->closeconnect();
		return true;
	}

	function preguntasRespuestas($idpregunta,$idrespuesta){
		$idpreguntaint = (int)$idpregunta;
		$idrespuestaint = (int)$idrespuesta;
		$query = "INSERT into Preguntas_has_Respuestas values ($idpreguntaint,$idrespuestaint)";
		if (!parent:: __construct()) 
			die("Eror en la conexion para almacenar la relacion preguntas y respuesas"+mysql_error());
		if (!$almacenar = mysql_query($query)) {
			die("Error al almacenar las preguntas y respuestas "+mysql_error());
			return false;
		}
		$this->closeconnect();
		return true;
	}

	function CursosPreguntas($idcurso,$idpregunta){
		$idcursoint = (int)$idcurso;
		$idpreguntaint = (int)$idpregunta;
		$query = "INSERT into Cursos_semestres_has_Preguntas values ($idcursoint,$idpreguntaint)";
		if (!parent:: __construct()) 
			die("Eror en la conexion para almacenar la relacion preguntas y respuesas"+mysql_error());
		if (!$almacenar = mysql_query($query)) {
			die("Error al almacenar las preguntas y respuestas "+mysql_error());
			return false;
		}
		$this->closeconnect();
		return true;
	}
}

/**
* Clase que administra las preguntas
*/
class Preguntas extends Conexion
{	
	public $preguntas;
	
	function __construct()
	{
		
	}

	function solicitar($idcurso){
		$query = "SELECT P.idPreguntas, P.Pregunta from Preguntas P inner join Respuestas_has_Preguntas RP on P.idPreguntas = RP.Preguntas_idPreguntas and RP.Cursos_semestres_idCurso_semestre = $idcurso group by idPreguntas";
		if (!parent:: __construct()) 
			die("Error al conectar para las preguntas ".mysql_error());
		if(!$this->preguntas = mysql_query($query))
			die("Eror al consultar las preguntas"+mysql_error());
		$this->closeconnect();
	}

	function obtener(){
		if($preguntamodelo = mysql_fetch_array($this->preguntas,MYSQL_ASSOC))
			return $preguntamodelo;
		else
			return false;
	}
}

/**
* Clase que administra las respuestas
*/
class Respuestas extends Conexion
{
	public $respuestas;

	function __construct()
	{
		
	}

	function buscar($idpregunta){
		$idpreguntaint = (int)$idpregunta;
		$query = "SELECT R.idRespuestas, R.Respuestascol from Respuestas R inner join Respuestas_has_Preguntas RP on R.idRespuestas = RP.Respuestas_idRespuestas and RP.Preguntas_idPreguntas = $idpreguntaint";
		if (!parent:: __construct()) 
			die("Error en la conexion para buscar las respuestas"+mysql_error());
		if (!$this->respuestas = mysql_query($query)) 
			die("Error en la busqueda de las respuestas "+mysql_error());
		$this->closeconnect();
	}

	function obtener(){
		if($respuestamodelo = mysql_fetch_array($this->respuestas,MYSQL_ASSOC))
			return $respuestamodelo;
		else
			return false;
	}

	function buscarTodos(){
		$query = "SELECT * from Respuestas";
		if (!parent:: __construct()) 
			die("Error en la conexion para buscar las respuestas"+mysql_error());
		if (!$this->respuestas = mysql_query($query)) 
			die("Error en la busqueda de las respuestas "+mysql_error());
		$this->closeconnect();
	}
}

/**
* Clase que realiza varias consultas
*/
class Consultas extends Conexion
{
	public $pensum;
	public $cursos;
	public $preguntas;
	function __construct()
	{
		
	}

	function cursos(){
		$query = "SELECT * from Cursos";
		if (!parent:: __construct()) 
			die("Error en la conexion para buscar los pensum "+mysql_error());
		if (!$this->cursos = mysql_query($query)) 
			die("Error en la busqueda de los pensum "+mysql_error());
		$this->closeconnect();
	}

	function cursosActuales(){
		$query = "SELECT CS.idCurso_semestre, C.nombreMateria from Cursos C inner join Cursos_Pensum CP on C.idMateria = CP.Cursos_idMateria and CP.Pensum_idPensum = 1  inner join Cursos_semestres CS  on CP.idCurso_pensum = CS.Cursos_Pensum_idCurso_pensum";
		if (!parent:: __construct()) 
			die("Error en la conexion para buscar los pensum "+mysql_error());
		if (!$this->cursos = mysql_query($query)) 
			die("Error en la busqueda de los pensum "+mysql_error());
		$this->closeconnect();
	}

	function obtenerCruso(){
		if($cursomodelo = mysql_fetch_array($this->cursos,MYSQL_ASSOC))
			return $cursomodelo;
		else
			return false;
	}

	function pensum(){
		$query = "SELECT * from Pensum";
		if (!parent:: __construct()) 
			die("Error en la conexion para buscar los pensum "+mysql_error());
		if (!$this->pensum = mysql_query($query)) 
			die("Error en la busqueda de los pensum "+mysql_error());
		$this->closeconnect();
	}

	function preguntas(){
		$query = "SELECT * from Preguntas";
		if (!parent:: __construct()) 
			die("Error en la conexion para buscar los pensum "+mysql_error());
		if (!$this->preguntas = mysql_query($query)) 
			die("Error en la busqueda de los pensum "+mysql_error());
		$this->closeconnect();
	}

	function obtenerPensum(){
		if($preguntamodelo = mysql_fetch_array($this->pensum,MYSQL_ASSOC))
			return $preguntamodelo;
		else
			return false;
	}

	function obtenerPregunta(){
		if($preguntamodelo = mysql_fetch_array($this->preguntas,MYSQL_ASSOC))
			return $preguntamodelo;
		else
			return false;
	}
}
?>