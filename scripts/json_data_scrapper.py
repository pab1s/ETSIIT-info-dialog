import requests
from bs4 import BeautifulSoup
import json

# URL de la página web
url = 'https://www.ugr.es/estudiantes/grados/grado-ingenieria-informatica'

# Realizar una solicitud GET a la página
response = requests.get(url)

# Parsear el contenido HTML de la página
soup = BeautifulSoup(response.text, 'html.parser')

# Create a data structure to store the extracted information
data = {
    "titulation_name": "",
    "courses": []
}

# Obtener el encabezado h1 que es el nombre de la titulación
nombre_titulacion = soup.find('h1', class_='page-title').text.strip()
data["titulation_name"] = nombre_titulacion

# Encontrar todas las secciones de cursos
secciones_cursos = soup.find_all('div', class_='block-views-blockpeople-subject-asignatura-persona')

# Diccionario para mapear las abreviaturas de los días a nombres completos
dias_abreviaturas = {
    'L': 'Lunes',
    'M': 'Martes',
    'X': 'Miércoles',
    'J': 'Jueves',
    'V': 'Viernes'
}

# Iterar a través de las secciones de cursos
for seccion_curso in secciones_cursos:
    # Create a dictionary for each course
    course = {
        "course_number": "",
        "semesters": []
    }
    
    # Obtener el número de curso
    numero_curso = seccion_curso.find('h2').text.strip()
    course["course_number"] = numero_curso

    # Obtener las asignaturas por semestre
    tabla_semestres = seccion_curso.find_all('table', class_='tabla-semestre')

    for tabla in tabla_semestres:
        semestre = tabla.find('caption').text.strip()
        semester_data = {
            "semester_name": 1 if semestre == "Primer semestre" else 2,
            "subjects": []
        }

        asignaturas = tabla.find_all('td', class_='asignatura')

        for asignatura in asignaturas:
            subject = {
                "subject_name": "",
                "professors": [],
                "schedules": []
            }

            nombre_asignatura = asignatura.a.text.strip()
            subject["subject_name"] = nombre_asignatura

            # Obtener el enlace de la asignatura
            enlace_asignatura = asignatura.a['href']

            # Realizar una solicitud GET al enlace de la asignatura
            response_asignatura = requests.get(enlace_asignatura)

            # Parsear el contenido HTML de la página de la asignatura
            soup_asignatura = BeautifulSoup(response_asignatura.text, 'html.parser')

            # Encontrar la sección de profesorado
            seccion_profesorado = soup_asignatura.find_all('div', class_='profesorado-asignatura')

            for profesorado in seccion_profesorado:
                tipo_profesorado = profesorado.find('h3').text.strip()
                professors_data = {
                    "professor_type": tipo_profesorado,
                    "professors_list": []
                }

                profesores = profesorado.find_all('li', class_='profesor')
                for profesor in profesores:
                    nombre_profesor = profesor.a.text.strip()
                    grupos = profesor.find('span', class_='grupos').text.strip()
                    # grupos = ' '.join(grupos.split())
                    grupos = grupos.split()[-1] # Coge solo uno de los grupos, ver como arreglar 
                    professor_data = {
                        "professor_name": nombre_profesor,
                        "groups": grupos
                    }
                    professors_data["professors_list"].append(professor_data)

                subject["professors"].append(professors_data)

            # Encontrar la sección de horarios
            seccion_horarios = soup_asignatura.find('div', class_='horario')

            if seccion_horarios:
                schedules_data = {
                    "schedules_list": []
                }

                # Buscar todas las filas de horarios
                filas_horarios = seccion_horarios.find_all('tr')

                # Obtener los nombres de los días de la semana
                dias_semana = []
                for dia in filas_horarios[0].find_all('div', class_='dia-red'):
                    dia_abreviatura = dia.text.strip()
                    dias_semana.append(dia_abreviatura)

                # Iterar a través de las filas de horarios
                for fila in filas_horarios[1:]:
                    # Obtener las celdas de horario
                    celdas_horario = fila.find_all('td')

                    # Iterar a través de las celdas de horario
                    for i, celda in enumerate(celdas_horario):
                        if celda.find('div', class_='clase'):
                            # Hacemos split y cogemos el último elemento que es el grupo
                            grupo = celda.find('div', class_='grupo').text.strip().split(' ')[1] # Extraemos solo el grupo
                            otros_datos = celda.find('div', class_='otros-datos').text.strip()

                            # Extraer información del horario
                            info_horario = otros_datos.split('\n')
                            aula = info_horario[0].split(': ')[1]
                            fechas_horario = info_horario[2].split(': ')[1]
                            horario = info_horario[3].split(': ')[1]
                            horario = horario.split(' ')[1::2]
                            schedule_data = {
                                "group": grupo,
                                "day": dias_semana[i],
                                "classroom": aula,
                                "dates": fechas_horario,
                                "start_time": horario[0],
                                "end_time": horario[1]
                            }
                            schedules_data["schedules_list"].append(schedule_data)

                subject["schedules"].append(schedules_data)

            semester_data["subjects"].append(subject)

        course["semesters"].append(semester_data)

    data["courses"].append(course)

# Guardar archivo a formato JSON
with open('ugr_data.json', 'w', encoding='utf-8') as json_file:
    json.dump(data, json_file, ensure_ascii=False, indent=4)

print('Data saved to ugr_data.json')
