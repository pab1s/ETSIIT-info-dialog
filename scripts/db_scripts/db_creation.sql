CREATE TABLE etsiit_courses (
    indice INT AUTO_INCREMENT PRIMARY KEY,
    titulacion VARCHAR(100),
    asignatura VARCHAR(100),
    especialidad VARCHAR(50),
    curso VARCHAR(50),
    semestre VARCHAR(50),
    grupo VARCHAR(50),
    tipo_grupo VARCHAR(50),
    profesor VARCHAR(50),
    dia_de_la_semana VARCHAR(50),
    hora_inicio TIME,
    hora_fin TIME
);