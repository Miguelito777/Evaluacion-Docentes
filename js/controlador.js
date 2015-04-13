function cargarlogin(){
	var usuario = prompt("Usuario");
	var password = prompt("Password");
	var loginuser = new Login(usuario,password);
	loginuser.usuarioo();

	setTimeout(function(){
		if(loginuser.usuarioencontrado == "estudiante")
		window.location = "../EvaluacionDocentes/estudiantes.html";
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
			var preguntas_object = $.parseJSON(data);
			var preguntasarray = preguntas.convertirObject(preguntas_object);
			preguntas.mostrar(preguntasarray);
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
	$("#pensumtable").append("<tr><td>"+pensum+"</td></tr>");
}

function verPensumns(){
	var consulta = new Consultas();
	var pensum_array = [];

	consulta.pensum();
	setTimeout(function(){
		pensum_array = consulta.pensum_array;
		$("#tables").append("<tr><th>Id Pensum</th><th>Anio del Pensum</th></tr>");
		for (var i = 0; i < pensum_array.length; i++) {
			$("#tables").append("<tr><td>"+pensum_array[i][0]+"</td><td>"+pensum_array[i][1]+"</td></tr>");
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
									window.location = "../EvaluacionDocentes/cursos.html"
								else
									console.log("Error al guardar en session la variable de idpensum y pensum");
							}
						})
					}
				};
			currentRow.onclick = createClickHandler(idpensum,nombrepensum);	
		};
	},1000);	
}

function verCursos(){
	var cursos = new Cursos();
	cursos.consultar();
	cursos.pensum();
	var pensumcursos = [];
	var cursosmostrar = [];

	setTimeout(function(){
		pensumcursos = cursos.pensumarray;
		document.getElementById("pensum").innerHTML = "<p class = 'lead'>Asignar cursos al pensum: "+pensumcursos[1][0]+pensumcursos[1][1]+pensumcursos[1][2]+pensumcursos[1][3]+"</p>";
		cursosmostrar = cursos.cursos_array;
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
				function (idcurso,nombrecurso) {
					return function(){
						console.log("Estos son los datos del curso que eligio "+idcurso+" "+nombrecurso);
					}
				};
			currentRow.onclick = createClickHandler(idcurso,nombrecurso);	
		};
	},50)
}