function cargarlogin(){
	var usuario = $("#Usuario").val();
	var password = $("#Password").val();
	console.log(usuario);
	console.log(password);

	var loginuser = new Login(usuario,password);
	loginuser.usuarioo();

	setTimeout(function(){
		if(loginuser.usuarioencontrado == "estudiante")
			window.location = "../EvaluacionDocentes/estudiantes.html";
		if(loginuser.usuarioencontrado == "docente")
			window.location = "../EvaluacionDocentes/suite.php";
	}, 500);
}

function cursosDisponibles(){
	var cursos_array = [];
	var miscursos = new Cursos();
	$.ajax({
		data : {solicitarcursos : true},
		url : "controlador.php",
		type : "GET",
		success : function (data){
			var cursos_object = $.parseJSON(data);
			cursos_array = miscursos.convertirObject(cursos_object);
			miscursos.mostrarSelect(cursos_array,"#cursos");
		}
	})
}

function cuestionario(idcurso){
	var preguntas = new Preguntas();
	$.ajax({
		url : "controlador.php",
		type : "POST",
		data : {preguntas : idcurso},
		success : function(data){
			//var preguntas_object = $.parseJSON(data);
			//var preguntasarray = preguntas.convertirObject(preguntas_object);
			//preguntas.mostrar(preguntasarray);
			window.location = "../EvaluacionDocentes/cuestionario.html"
			//console.log(data);
		}
	})
}

function registrarCurso(){
	var idcurso = $("#idcurso").val();
	var nombrecurso = $("#nombrecurso").val();
	var cursos = new Cursos();
	cursos.guardarNuevoCurso(idcurso,nombrecurso);
	$("#cursos").append("<tr><td>"+idcurso+"</td><td>"+nombrecurso+"</td></tr>");
}

function registrarPensum(){
	var pensum = $("#pensum").val();
	var almacenar = new Almacenar();
	almacenar.pensum(pensum);
	$("#tables").append("<tr><td>"+pensum+"</td></tr>");
}

function verPensumns(){
	var consulta = new Consultas();
	var pensum_array = [];

	consulta.pensum();
	setTimeout(function(){
		pensum_array = consulta.pensum_array;
		$("#tables").append("<tr><th>Anio del Pensum</th></tr>");
		for (var i = 0; i < pensum_array.length; i++) {
			$("#tables").append("<tr><td>"+pensum_array[i][1]+"</td></tr>");
		};

		var table = document.getElementById("tables");
		var rows = table.getElementsByTagName("tr");

		for (var i = 0; i < rows.length; i++) {
			var idpensum = pensum_array[i][0];
			var nombrepensum = pensum_array[i][1];
			var currentRow = table.rows[i+1];
			var createClickHandler = 
				function (idpensum,nombrepensum) {
					return function(){
						$.ajax({
							data : {idpensum : idpensum, nombrepensum : nombrepensum},
							url : "controlador.php",
							type : "POST",
							success : function(data){
								if(data == 1)
									window.location = "../EvaluacionDocentes/relacionPensumCursos.html"
								else
									console.log("Error al guardar en session la variable de idpensum y pensum");
							}
						})
					}
				};
			currentRow.onclick = createClickHandler(idpensum,nombrepensum);	
		};
	},500);	
}



function verPreguntas(){
	var consulta = new Consultas();
	var preguntas_array = [];
	consulta.preguntas();

	setTimeout(function(){
		preguntas_array = consulta.preguntas_array;
		$("#tables").append("<tr><th>Preguntas</th></tr>");
		for (var i = 0; i < preguntas_array.length; i++) {
			$("#tables").append("<tr><td>"+preguntas_array[i][1]+"</td></tr>");
		};
	},500);	
}

function seleccionarPreguntas(){
	var consulta = new Consultas();
	var preguntas_respuestas = new Relaciones();
	var preguntas = [];
	preguntas_respuestas.setArray(preguntas);
	var preguntas_array = [];
	consulta.preguntas();

	setTimeout(function(){
		preguntas_array = consulta.preguntas_array;
		$("#tables").append("<tr><th>Preguntas</th><th>Seleccionar</th></tr>");
		for (var i = 0; i < preguntas_array.length; i++) {
			$("#tables").append("<tr><td>"+preguntas_array[i][1]+"</td><td><div class='checkbox'><input type='checkbox'></div></td></tr>");
		};

		var table = document.getElementById("tables");
		var rows = table.getElementsByTagName("tr");
		
		for (var i = 0; i < rows.length; i++) {
			var currentRow = table.rows[i+1];
			var createClickHandler = 
				function (idpregunta,nombrepregunta) {
					return function(){
						console.log("Estos son los datos del curso que eligio "+idpregunta+" Pregunta "+nombrepregunta);
						preguntas_respuestas.actualizarArrayUnidimencional(idpregunta);
						console.log(preguntas_respuestas.array);
					};
				};
			currentRow.onclick = createClickHandler(preguntas_array[i][0],preguntas_array[i][1]);
		};
	},500);
	document.getElementById("buscarrespuestas").onclick = function(){
			relacionarPreguntasRespuestas(preguntas_respuestas.array);
	}	
}

function relacionarPreguntasRespuestas(array_preguntas){
	document.getElementById("descripcion").innerHTML = "";
	document.getElementById("descripcion").innerHTML = "<br/> <h1>Seleccione las respuestas a asignar a estas preguntas</h1>";
	document.getElementById("preguntas_respuestas").innerHTML = "";
	document.getElementById("relacionpreguntasrespuestas").innerHTML = "";
	document.getElementById("relacionpreguntasrespuestas").innerHTML = "<button type='button' class='btn btn-primary btn-lg btn-block' id='buscarrespuestas'>Relacionar Preguntas y respuestas</button>";
	document.getElementById("preguntas_respuestas").innerHTML = "<div class='col-xs-8' id = 'preguntas_respuestas_todas'></div><div class='col-xs-4' id='preguntas_respuestas_seleccionadas'></div>";	
	document.getElementById("preguntas_respuestas_todas").innerHTML = "<table class='table table-hover' id='tables'></table>";
	var consulta = new Consultas();
	var respuestas = [];
	var idrespuestas = [];
	var preguntas_respuestas = new Relaciones();
	preguntas_respuestas.setArray(idrespuestas);
	preguntas_respuestas.setArrayDos(respuestas,"preguntas_respuestas_seleccionadas");
	var respuestas_array = [];
	consulta.respuestas();

	setTimeout(function(){
		respuestas_array = consulta.respuestas_array;
		$("#tables").append("<tr><th>Respuestas</th></tr>");
		for (var i = 0; i < respuestas_array.length; i++) {
			$("#tables").append("<tr><td>"+respuestas_array[i][1]+"</td></tr>");
		};

		var table = document.getElementById("tables");
		var rows = table.getElementsByTagName("tr");
		
		
		for (var i = 0; i < rows.length; i++) {
			var currentRow = table.rows[i+1];
			var createClickHandler = 
				function (idpregunta,nombrepregunta) {
					return function(){
						console.log("Estos son los datos de la respuesta que eligio id : "+idpregunta+" Respuesta: "+nombrepregunta);
						preguntas_respuestas.actualizarArrayUnidimencional(idpregunta);
						preguntas_respuestas.actualizarArrayUnidimencionalDos(nombrepregunta);
						preguntas_respuestas.actualizarTabla();
					};
				};
			currentRow.onclick = createClickHandler(respuestas_array[i][0],respuestas_array[i][1]);
		};
	
	},500);

	document.getElementById("buscarrespuestas").onclick = function(){
		preguntas_respuestas.guardarPreguntasRespustas(array_preguntas,preguntas_respuestas.array)
	}
}


function verRespuestas(){
	var consulta = new Consultas();
	var respuestas_array = [];
	consulta.respuestas();

	setTimeout(function(){
		respuestas_array = consulta.respuestas_array;
		$("#tables").append("<tr><th>Respuestas</th></tr>");
		for (var i = 0; i < respuestas_array.length; i++) {
			$("#tables").append("<tr><td>"+respuestas_array[i][1]+"</td></tr>");
		};	
	},500);	
}

function registrarPregunta(){
	var porId = document.getElementById("pregunta").value;
	var almacenar = new Almacenar();
	almacenar.pregunta(porId);
	$("#tables").append("<tr><td>"+porId+"</td></tr>");
}

function registrarRespuesta(){
	var porId = document.getElementById("respuesta").value;
	var almacenar = new Almacenar();
	almacenar.respuesta(porId);
	$("#tables").append("<tr><td>"+porId+"</td></tr>");
	
}

function verCursos(){
	var cursos = new Cursos();
	var cursos_pensum = new Relaciones();
	var Cursos_Pensum = [];
	cursos_pensum.setArray(Cursos_Pensum);
	cursos.consultar();
	cursos.pensum();
	var pensumcursos = [];
	var cursosmostrar = [];

	setTimeout(function(){
		pensumcursos = cursos.pensumarray;
		document.getElementById("pensum").innerHTML = "<p class = 'lead'>Asignar cursos al pensum: "+pensumcursos[1][0]+pensumcursos[1][1]+pensumcursos[1][2]+pensumcursos[1][3]+"</p>";
		cursosmostrar = cursos.cursos_array;
		pensumcursos[0][0];
		$("#tables").append("<tr><th>Id Curso</th><th>nombre del Curso</th><th>Asignar Curso</th></tr>");
		for (var i = 0; i < cursosmostrar.length; i++) {
			$("#tables").append("<tr><td>"+cursosmostrar[i][0]+"</td><td>"+cursosmostrar[i][1]+"</td><td><div class='checkbox'><label><input type='checkbox' value=''></label></div></td></tr>");
		};

		var table = document.getElementById("tables");
		var rows = table.getElementsByTagName("tr");
		
		
		for (var i = 0; i < rows.length; i++) {
			var idcurso = cursosmostrar[i][0];
			var nombrecurso = cursosmostrar[i][1];
			var currentRow = table.rows[i+1];
			var createClickHandler = 
				function (idcurso,nombrecurso,pensumcurso) {
					return function(){
						console.log("Estos son los datos del curso que eligio "+idcurso+" "+nombrecurso+" del pensum "+pensumcurso);
						cursos_pensum.actualizarArray(idcurso,pensumcurso);
					};
				};
			currentRow.onclick = createClickHandler(idcurso,nombrecurso,pensumcursos[0][0]);
		};	
		
	},50)
	document.getElementById("relacionar").onclick = function(){
		var convertirdor = new convertirArray();
		convertirdor.keys = ["idcurso","idpensum"];
		convertirdor.array = cursos_pensum.array;
		convertirdor.convertirArrayaObject();
		var json_string = JSON.stringify(convertirdor.output);
		cursos_pensum.guardarPensumCurso(json_string);
		}; 	
}

function verCursosAlmacenados(){
	var cursos = new Cursos();
	var llevar_cursos = new Relaciones();
	var cursos_llevar = [];
	llevar_cursos.setArray(cursos_llevar);
	cursos.consultar();
	var cursosmostrar = [];
	

	setTimeout(function(){
		cursosmostrar = cursos.cursos_array;
		$("#cursos").append("<tr><th>Id Curso</th><th>nombre del Curso</th><th>Asignar Curso</th></tr>");
		for (var i = 0; i < cursosmostrar.length; i++) {
			$("#cursos").append("<tr><td>"+cursosmostrar[i][0]+"</td><td>"+cursosmostrar[i][1]+"</td><td><div class='checkbox'><label><input type='checkbox' value=''></label></div></td></tr>");
		};

		var table = document.getElementById("cursos");
		var rows = table.getElementsByTagName("tr");

		for (var i = 0; i < rows.length; i++) {
			var idcurso = cursosmostrar[i][0];
			var nombrecurso = cursosmostrar[i][1];
			var currentRow = table.rows[i+1];
			var createClickHandler = 
				function (idcurso,nombrecurso) {
					return function(){
						console.log("Estos son los datos del curso que se va a llevar "+idcurso+" "+nombrecurso);
						llevar_cursos.actualizarArrayUnidimencional(idcurso);
						console.log(llevar_cursos.array);
					};
				};
			currentRow.onclick = createClickHandler(idcurso,nombrecurso);
		};	
	},50);
	
	document.getElementById("relacionar").onclick = function (){
		relacionarCursosRespuestas(llevar_cursos.array);
	}
}

function verCursosAlmacenadosActuales(){
	var cursos = new Cursos();
	var llevar_cursos = new Relaciones();
	var cursos_llevar = [];
	llevar_cursos.setArray(cursos_llevar);
	cursos.consultarPensumActual();
	var cursosmostrar = [];
	

	setTimeout(function(){
		cursosmostrar = cursos.cursos_array;
		$("#cursos").append("<tr><th>Id Curso</th><th>nombre del Curso</th><th>Asignar Curso</th></tr>");
		for (var i = 0; i < cursosmostrar.length; i++) {
			$("#cursos").append("<tr><td>"+cursosmostrar[i][0]+"</td><td>"+cursosmostrar[i][1]+"</td><td><div class='checkbox'><label><input type='checkbox' value=''></label></div></td></tr>");
		};

		var table = document.getElementById("cursos");
		var rows = table.getElementsByTagName("tr");

		for (var i = 0; i < rows.length; i++) {
			var idcurso = cursosmostrar[i][0];
			var nombrecurso = cursosmostrar[i][1];
			var currentRow = table.rows[i+1];
			var createClickHandler = 
				function (idcurso,nombrecurso) {
					return function(){
						console.log("Estos son los datos del curso que se va a llevar "+idcurso+" "+nombrecurso);
						llevar_cursos.actualizarArrayUnidimencional(idcurso);
						console.log(llevar_cursos.array);
					};
				};
			currentRow.onclick = createClickHandler(idcurso,nombrecurso);
		};	
	},50);
	
	document.getElementById("relacionar").onclick = function (){
		relacionarCursosRespuestas(llevar_cursos.array);
	}
}

function relacionarCursosRespuestas(array_cursos){
	document.getElementById("descripcion").innerHTML = "";
	document.getElementById("descripcion").innerHTML = "<br/> <h1>Seleccione las preguntas que desea asignar a estos cursos...</h1>";
	document.getElementById("preguntas_respuestas").innerHTML = "";
	document.getElementById("relacionpreguntasrespuestas").innerHTML = "";
	document.getElementById("relacionpreguntasrespuestas").innerHTML = "<button type='button' class='btn btn-primary btn-lg btn-block' id='buscarrespuestas'>Relacionar Preguntas y respuestas</button>";
	document.getElementById("preguntas_respuestas").innerHTML = "<div class='col-xs-8' id = 'preguntas_respuestas_todas'></div><div class='col-xs-4' id='preguntas_respuestas_seleccionadas'></div>";	
	document.getElementById("preguntas_respuestas_todas").innerHTML = "<table class='table table-hover' id='tables'></table>";
	var consulta = new Consultas();
	var respuestas = [];
	var idrespuestas = [];
	var preguntas_respuestas = new Relaciones();
	preguntas_respuestas.setArray(idrespuestas);
	preguntas_respuestas.setArrayDos(respuestas,"preguntas_respuestas_seleccionadas");
	var respuestas_array = [];
	consulta.preguntas();

	setTimeout(function(){
		respuestas_array = consulta.preguntas_array;
		$("#tables").append("<tr><th>Respuestas</th></tr>");
		for (var i = 0; i < respuestas_array.length; i++) {
			$("#tables").append("<tr><td>"+respuestas_array[i][1]+"</td></tr>");
		};

		var table = document.getElementById("tables");
		var rows = table.getElementsByTagName("tr");
		
		
		for (var i = 0; i < rows.length; i++) {
			var currentRow = table.rows[i+1];
			var createClickHandler = 
				function (idpregunta,nombrepregunta) {
					return function(){
						console.log("Estos son los datos de la respuesta que eligio id : "+idpregunta+" Respuesta: "+nombrepregunta);
						preguntas_respuestas.actualizarArrayUnidimencional(idpregunta);
						preguntas_respuestas.actualizarArrayUnidimencionalDos(nombrepregunta);
						preguntas_respuestas.actualizarTabla();
					};
				};
			currentRow.onclick = createClickHandler(respuestas_array[i][0],respuestas_array[i][1]);
		};
	
	},500);

	document.getElementById("buscarrespuestas").onclick = function(){
		preguntas_respuestas.guardarCursosPreguntas(array_cursos,preguntas_respuestas.array)
	}
}


function mostrarPregunta(){
	document.getElementById("pregunta").innerHTML = "";
	document.getElementById("respuestas").innerHTML = "";
	var elementosactuales = [];
	var consultaunitaria = new Consultas();

	$.ajax({
		data : {preguntaactual : true},
		url : "controlador.php",
		type : "POST",
		success : function (data){
			var preguntas_object = $.parseJSON(data);
			consultaunitaria.preguntas_array = consultaunitaria.convertirObject(preguntas_object); 
		}
	})

	setTimeout(function(){
		document.getElementById("pregunta").innerHTML = "<table class='table'><tr><td> <p class = 'lead'>¿"+consultaunitaria.preguntas_array[0][1]+"</p></td></tr></table>";
		document.getElementById("respuestas").innerHTML = "<table class = 'table-hover' id='tablarespuestas'></table>";
		for (var i = 0; i < consultaunitaria.preguntas_array[1].length; i++) {
			$("#tablarespuestas").append("<tr><td><p class='lead'>"+consultaunitaria.preguntas_array[2][i]+"</p></td></tr>");
		};

		var table = document.getElementById("tablarespuestas");
		var rows = table.getElementsByTagName("tr");
		
		
		for (var i = 0; i < rows.length; i++) {
			var currentRow = table.rows[i];
			var createClickHandler = 
				function (idpregunta,idrespuesta) {
					return function(){
						//console.log("Estos son los datos de la respuesta que eligio id : "+idpregunta+" Respuesta: "+idrespuesta);
						$.ajax({
							data : {idpregunta : idpregunta, idrespuesta : idrespuesta},
							url : "controlador.php",
							type : "POST",
							success : function (data){
								if (data == 1) {
									alert("jalalo");
									//window.location = "../EvaluacionDocentes/cuestonario.html";
								};
								//alert(data);
							} 
						})
					};
				};
			currentRow.onclick = createClickHandler(consultaunitaria.preguntas_array[0][0],consultaunitaria.preguntas_array[1][i]);
		};


	},500);
	
}

//polanco@oj.gob.gt