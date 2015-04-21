function Login(usuario,password){
	var usuario = usuario;
	var password = password;
	
	this.getUsuario = function(){
		return usuario;
	}
	this.getPassword = function(){
		return password;
	}
	this.setUsuario = function(usuario){
		usuario = usuario;
	}
}

Login.prototype.usuarioo = function(){
	var _this = this;
	$.ajax({
		url : "controlador.php",
		type : "POST",
		data : {usuario:this.getUsuario(),password:this.getPassword()},
		success : function (data){
			_this.usuarioencontrado = data;
		}
	}).done(function(data,textStatus,jqXHR){
		if (console && console.log)
			console.log("Usuario y password solicitados correctamente ");
	}).fail(function(jqXHR,textStatus,errorThrown){
		if (console && console.log)
			console.log("Error en la peticion de buscar al usuario y contrasenia");
	});
}


/** 
* 	Clase de administra los cursos
*/

function Cursos(){
}
Cursos.prototype.pensum = function(){
	var _this = this;
	$.ajax({
		data : {traerpensum : true},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			var pensum_object = $.parseJSON(data);
			_this.pensumarray = _this.convertirObject(pensum_object);
		}
	})
}
Cursos.prototype.consultar = function(){
	var _this = this;
	$.ajax({
		data : {consultarcursos : true},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			var cursos_object = $.parseJSON(data);
			_this.cursos_array = _this.convertirObject(cursos_object);
		}
	})
}

Cursos.prototype.consultarPensumActual = function(){
	var _this = this;
	$.ajax({
		data : {consultarcursospensumactual : true},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			var cursos_object = $.parseJSON(data);
			_this.cursos_array = _this.convertirObject(cursos_object);
		}
	})
}

Cursos.prototype.guardarNuevoCurso = function(idcurso,nombrecurso){ 
	$.ajax({
		data : {idcurso : idcurso, nombrecurso : nombrecurso},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			console.log(data);
		}
	})
}

Cursos.prototype.convertirObject = function(object){
	var cursos_array = [];
	for(var i in object){
		var curso = [];
		var k = 0;
		for(var j in object[i]){
			curso[k] = object[i][j];
			k++;
		}
		cursos_array.push(curso);
	}
	return cursos_array;
}

Cursos.prototype.mostrarSelect = function(array,elemento){
	for (var i = 0; i < array.length; i++) {
		$(elemento).append("<option value="+array[i][1]+">"+array[i][0]+"</option>");
	};
	$(elemento).append("<option value="+0+" selected = 'selected'>Selecciona un curso</option>")
}

/**
* Clase que administra las preguntas
*/

function Preguntas() {
}

Preguntas.prototype.convertirObject = function(object){
	var cursos_array = [];
	for(var i in object){
		var curso = [];
		var k = 0;
		for(var j in object[i]){
			curso[k] = object[i][j];
			k++;
		}
		cursos_array.push(curso);
	}
	return cursos_array;
}

Preguntas.prototype.mostrar = function(arraypreguntas){
	var _this = this;
	console.log(arraypreguntas.length);
	
		document.getElementById("preguntas").innerHTML = "<h1><br /><p class='text-info'>¿"+arraypreguntas[i][1]+"</p></h1>";
		this.respuestas(arraypreguntas[i][0]);
		setTimeout(function(){
			for (var k = 0; k < _this.respuestas_array.length; k++) {
				$("#tablerespuestas").append("<tr><td><p class='lead'>"+_this.respuestas_array[k][1]+"</p></td></tr>"); 	
			 	
			 };
				var table = document.getElementById("tablerespuestas");
				var rows = table.getElementsByTagName("tr");
				for (var j = 0; j < rows.length; j++) {
					var idpensum = _this.respuestas_array[j][0];
					var currentRow = table.rows[j];
					var createClickHandler = 
					function (idpensum,idpregunta) {
						return function(){
							/*$.ajax({
							data : {idpensum : idpensum, nombrepensum : nombrepensum},
							url : "controlador.php",
							type : "POST",
							success : function(data){
								if(data == 1)
									window.location = "../EvaluacionDocentes/relacionPensumCursos.html"
								else
									console.log("Error al guardar en session la variable de idpensum y pensum");
								}
							})*/
							alert("Id pregunta "+idpregunta+" Id Respuesta "+idpensum);
						}
					};
					currentRow.onclick = createClickHandler(idpensum,arraypreguntas[i][0]);	
				};
		},50)

}

Preguntas.prototype.respuestas = function(idpregunta){
	var _this = this;
	$.ajax({
		url : "controlador.php",
		type : "POST",
		data : {idpregunta : idpregunta},
		success : function (data){
			var respuestas_object = $.parseJSON(data);
			_this.respuestas_array = _this.convertirObject(respuestas_object);
		}
	});
}

/**
*  Clase generica que almacena datos
*/

function Almacenar (){

}

Almacenar.prototype.pensum = function(pensum){
	$.ajax({
		data : {pensum : pensum},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			console.log(data);
		}
	})
}

Almacenar.prototype.pregunta = function(pregunta){
	$.ajax({
		data : {pregunta : pregunta},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			console.log(data);
		}
	})
}

Almacenar.prototype.respuesta = function(respuesta){
	$.ajax({
		data : {respuesta : respuesta},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			console.log(data);
		}
	})
}

/**
* Clase que realiza consultas
*/

function Consultas (){

}

Consultas.prototype.convertirObject = function(object){
	var cursos_array = [];
	for(var i in object){
		var curso = [];
		var k = 0;
		for(var j in object[i]){
			curso[k] = object[i][j];
			k++;
		}
		cursos_array.push(curso);
	}
	return cursos_array;
}

Consultas.prototype.pensum = function(){
	var _this = this;
	$.ajax({
		data : {verpensums : true},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			var pensum_object = $.parseJSON(data);
			_this.pensum_array = _this.convertirObject(pensum_object);
		}
	})
}

Consultas.prototype.preguntas = function(){
	var _this = this;
	$.ajax({
		data : {verpreguntas : true},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			var preguntas_object = $.parseJSON(data);
			_this.preguntas_array = _this.convertirObject(preguntas_object);
		}
	})
}

Consultas.prototype.respuestas = function(){
	var _this = this;
	$.ajax({
		data : {verrespuestas : true},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			var respuestas_object = $.parseJSON(data);
			_this.respuestas_array = _this.convertirObject(respuestas_object);
			//alert(_this.respuestas_array);
		}
	})
}

/**
* Clase que realiza las relaciones
*/

function Relaciones (){

}

Relaciones.prototype.setArray = function(array){
	this.array = array;
}

Relaciones.prototype.setArrayDos = function(array,elemento){
	this.arraydos = array;
	this.elemento = elemento;
}

Relaciones.prototype.actualizarArray = function(dato,pensumcurso){
	
	var encontrado = -1;

	for (var i = 0; i < this.array.length; i++) {
		if (this.array[i][0] == dato) {
			encontrado = i;
			break;
		};
	};

	if (encontrado == -1) {
		var relacion = [dato,pensumcurso];
		this.array.push(relacion);	
	}
	else{
		this.array.splice(encontrado,1);
	}		
}

Relaciones.prototype.actualizarArrayUnidimencional = function(dato){
	var encontrado = -1;

	for (var i = 0; i < this.array.length; i++) {
		if (this.array[i] == dato) {
			encontrado = i;
			break;
		};
	};

	if (encontrado == -1) {
		this.array.push(dato);	
	}
	else{
		this.array.splice(encontrado,1);
	}		
}

Relaciones.prototype.actualizarArrayUnidimencionalDos = function(dato){
	var encontrado = -1;

	for (var i = 0; i < this.arraydos.length; i++) {
		if (this.arraydos[i] == dato) {
			encontrado = i;
			break;
		};
	};

	if (encontrado == -1) {
		this.arraydos.push(dato);	
	}
	else{
		this.arraydos.splice(encontrado,1);
	}		
}

Relaciones.prototype.guardarPensumCurso = function(pensumcurso){
	$.ajax({
		data : {pensum_curso : pensumcurso},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			if (data == 1)
				window.location = "../EvaluacionDocentes/suite.php";
		}
	})
}

Relaciones.prototype.guardarPreguntasRespustas = function(preguntas,respuestas){
	$.ajax({
		data : {preguntas_seleccionadas: preguntas, respuestas_seleccionadas : respuestas},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			if (data == 1)
				window.location = "../EvaluacionDocentes/suite.php";
		}
	})
}

Relaciones.prototype.guardarCursosPreguntas = function(cursos,preguntas){
	$.ajax({
		data : {cursos_seleccionados: cursos, preguntas_seleccionadas : preguntas},
		url : "controlador.php",
		type : "POST",
		success : function(data){
			if (data == 1)
				window.location = "../EvaluacionDocentes/suite.php";
			alert(data);
		}
	})
}
Relaciones.prototype.actualizarTabla = function (){
	document.getElementById(this.elemento).innerHTML = "";
	document.getElementById(this.elemento).innerHTML = "<table class='table' id='respuestasseleccionadas'><tr><th>Respuestas Seleccionadas</th></tr></table>";
	for (var i = 0; i < this.arraydos.length; i++) {
		$("#respuestasseleccionadas").append("<tr><td>"+this.arraydos[i]+"</td></tr>");
	};
}

/**
*
*/

function convertirArray(){

}


convertirArray.prototype.convertirArrayaObject = function(){	
    obj = null,
    this.output = [];
    for (var i = 0; i < this.array.length; i++) {
        obj = {};
        for (var k = 0; k < this.keys.length; k++) {
            obj[this.keys[k]] = this.array[i][k];
      	}
      	this.output.push(obj);
    }

}
