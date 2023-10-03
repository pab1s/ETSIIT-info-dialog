CREATE TABLE ugr_courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulacion VARCHAR(255),
    asignatura VARCHAR(255),
    curso VARCHAR(10),
    semestre VARCHAR(255),
    grupo VARCHAR(10),
    tipo_grupo VARCHAR(255),
    profesor VARCHAR(255),
    dia_de_la_semana VARCHAR(255),
    hora_inicio TIME,
    hora_fin TIME
);
