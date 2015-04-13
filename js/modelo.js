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
	console.log(arraypreguntas);
	for (var i = 0; i < arraypreguntas.length; i++) {
		document.getElementById("preguntas").innerHTML = "<p class='lead text-info'>¿"+arraypreguntas[i][1]+"</p>";
		this.respuestas(arraypreguntas[i][0]);
		setTimeout(function(){ 
			for (var i = 0; i < _this.respuestas_array.length; i++) {
				$("#tablerespuestasrarios").append("<td><div class='radio'> <label><input type='radio' name='optionsRadios' id='optionsRadios1' value='option1'></label></div></td>");
				$("#tablerespuestastexto").append("<td><p class='lead'>"+_this.respuestas_array[i][1]+"</p></td>"); 	
			 }; 
		},50)
	};
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
	var pensum;
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