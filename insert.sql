insert into Pensum(anio) values('2015');
insert into Cursos_Pensum(CUrsos_idMateria,Pensum_idPensum) values('1',1);
insert into Docentes(paswordDocente,nombresDocente,apellidosDocente,telefonoDocente,direccionDocente,DPI,IGSS,NIT)  values('123456789','Miguel Angel','Menchu Xoyon','77663236','Zona 1','2333555290301','22514253','2447271-9');
insert into Estudiantes (paswordEstudiante,nombresEstudiante,apellidosEstudiante,telefonoEstudiante,direccionEstudiante)  values('12345','wallace','Tzul Menchu','54789654','Zona Palin');
insert into Cursos_semestres (Ciclo,plan,anio,Docentes_idDocente,Cursos_Pensum_idCurso_pensum ) values (7,'diario','2015',1,1);
insert into Estudiantes_de_cursos(Estudiantes_idEstudiante,Cursos_semestres_idCurso_semestre) values (1,1);

CREATE TABLE Preguntas_has_Respuestas (Preguntas_idPreguntas INT NOT NULL, Respuestas_idRespuestas INT NOT NULL); ALTER TABLE Preguntas_has_Respuestas ADD FOREIGN KEY (Preguntas_idPreguntas) REFERENCES Preguntas(idPreguntas); ALTER TABLE Preguntas_has_Respuestas ADD FOREIGN KEY (Respuestas_idRespuestas) REFERENCES Respuestas(idRespuestas); 

CREATE TABLE Cursos_semestres_has_Preguntas (Cursos_semestres_has_Preguntas INT NOT NULL, Preguntas_idPreguntas INT NOT NULL); ALTER TABLE Cursos_semestres_has_Preguntas ADD FOREIGN KEY (Cursos_semestres_has_Preguntas) REFERENCES Cursos_semestres(idCurso_semestre); ALTER TABLE Cursos_semestres_has_Preguntas ADD FOREIGN KEY (Preguntas_idPreguntas) REFERENCES Preguntas(idPreguntas);


select CS.idCurso_semestre, C.nombreMateria from Cursos C inner join Cursos_Pensum CP on C.idMateria = CP.Cursos_idMateria and CP.Pensum_idPensum = 3  inner join Cursos_semestres CS  on CP.idCurso_pensum = CS.Cursos_Pensum_idCurso_pensum;

select C.nombreMateria from Cursos C  inner join Cursos_Pensum CP  on C.idMateria = CP.Cursos_idMateria and CP.Pensum_idPensum = 3 inner join Cursos_semestres CS on CP.idCurso_pensum = CS.Cursos_Pensum_idCurso_pensum;
