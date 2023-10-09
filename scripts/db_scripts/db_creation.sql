-- Creates a table named "etsiit_courses" with the following columns:
-- - indice: integer that auto-increments and serves as the primary key
-- - titulacion: string that represents the degree
-- - asignatura: string that represents the subject
-- - especialidad: string that represents the specialty
-- - curso: string that represents the course
-- - semestre: string that represents the semester
-- - grupo: string that represents the group
-- - tipo_grupo: string that represents the type of group
-- - profesor: string that represents the professor
-- - dia_de_la_semana: string that represents the day of the week
-- - hora_inicio: time that represents the start time of the class
-- - hora_fin: time that represents the end time of the class
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
