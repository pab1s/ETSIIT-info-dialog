import requests
from bs4 import BeautifulSoup
import csv
from unidecode import unidecode

# URL de la página web
grados_es = ['grado-ingenieria-informatica', 'grado-ingenieria-tecnologias-telecomunicacion',
             'grado-ingenieria-informatica-matematicas', 'grado-inga-informatica-administ-direcc-empresas']
url = 'https://www.ugr.es/estudiantes/grados/'

# Diccionario para mapear las abreviaturas de los días a los nombres completos
dias_abreviaturas = {
    'L': 'Lunes',
    'M': 'Martes',
    'X': 'Miércoles',
    'J': 'Jueves',
    'V': 'Viernes'
}

# Define el encabezado del archivo CSV
csv_header = [
    "indice",
    "titulacion",
    "asignatura",
    "especialidad",
    "curso",
    "semestre",
    "grupo",
    "tipo_de_grupo",
    "profesor",
    "dia_de_la_semana",
    "hora_inicio",
    "hora_fin"
]

# Agrega el encabezado a la lista de datos
data = []
data.append(csv_header)

# Crea un índice
index = 0

# Itera a través de los programas de grado
for grado in grados_es:
    # Realiza una solicitud GET a la página
    response = requests.get(url + grado)

    # Analiza el contenido HTML de la página
    soup = BeautifulSoup(response.text, 'html.parser')

    # Obtiene el encabezado h1, que es el nombre del programa de grado
    nombre_titulacion = soup.find('h1', class_='page-title').text.strip()

    # Encuentra todas las secciones de cursos
    secciones_cursos = soup.find_all(
        'div', class_='block-views-blockpeople-subject-asignatura-persona')

    # Itera a través de las secciones de cursos
    for seccion_curso in secciones_cursos:
        # Obtiene el número del curso
        curso = seccion_curso.find('h2').text.strip()

        # Obtiene las asignaturas por semestre
        tabla_semestres = seccion_curso.find_all(
            'table', class_='tabla-semestre')

        for tabla in tabla_semestres:
            semestre = tabla.find('caption').text.strip()

            asignaturas = tabla.find_all('td', class_='asignatura')

            for asignatura in asignaturas:
                # Obtiene el enlace a la asignatura
                enlace_asignatura = asignatura.a['href']

                # Obtiene el contenido de la asignatura
                asignatura = asignatura.text.strip()

                # Obtiene la especialidad de la asignatura
                inicio = asignatura.find('(')
                fin = asignatura.find(')', inicio)

                if inicio != -1 and fin != -1:
                    especialidad = asignatura[inicio + 1:fin]
                    asignatura = asignatura[:inicio] + asignatura[fin + 1:]
                else:
                    especialidad = ''

                # Elimina espacios en blanco repetidos
                asignatura = ' '.join(asignatura.split())

                # Realiza una solicitud GET al enlace de la asignatura
                response_asignatura = requests.get(enlace_asignatura)

                # Analiza el contenido HTML de la página de la asignatura
                soup_asignatura = BeautifulSoup(
                    response_asignatura.text, 'html.parser')

                # Encuentra la sección de profesorado
                seccion_profesorado = soup_asignatura.find_all(
                    'div', class_='profesorado-asignatura')

                for profesorado in seccion_profesorado:
                    tipo_profesorado = profesorado.find('h3').text.strip()
                    profesores = profesorado.find_all('li', class_='profesor')

                    for profesor in profesores:
                        nombre_profesor = profesor.a.text.strip()
                        grupos = profesor.find(
                            'span', class_='grupos').text.strip().split()[-1]

                        # Encuentra la sección de horarios
                        seccion_horarios = soup_asignatura.find(
                            'div', class_='horario')

                        if seccion_horarios:
                            # Encuentra todas las filas de horarios
                            filas_horarios = seccion_horarios.find_all('tr')

                            # Obtiene los nombres de los días de la semana
                            dias_semana = []
                            for dia in filas_horarios[0].find_all('div', class_='dia-red'):
                                dia_abreviatura = dia.text.strip()
                                dias_semana.append(dia_abreviatura)

                            # Itera a través de las filas de horarios
                            for fila in filas_horarios[1:]:
                                # Obtiene las celdas de horario
                                celdas_horario = fila.find_all('td')

                                # Itera a través de las celdas de horario
                                for i, celda in enumerate(celdas_horario):
                                    if celda.find('div', class_='clase'):
                                        grupo = celda.find(
                                            'div', class_='grupo').text.strip().split(' ')[1]
                                        otros_datos = celda.find(
                                            'div', class_='otros-datos').text.strip()
                                        info_horario = otros_datos.split('\n')
                                        aula = info_horario[0].split(': ')[1]
                                        fechas_horario = info_horario[2].split(': ')[
                                            1]
                                        horario = info_horario[3].split(': ')[
                                            1]
                                        horario = horario.split(' ')[1::2]

                                        # Crea una lista con los datos a guardar en formato CSV
                                        course_data = [
                                            index,
                                            nombre_titulacion,
                                            asignatura,
                                            especialidad,
                                            curso,
                                            semestre,
                                            grupo,
                                            tipo_profesorado,
                                            nombre_profesor,
                                            dias_abreviaturas[dias_semana[i]],
                                            horario[0]+":00",
                                            horario[1]+":00"
                                        ]

                                        # Aplica unidecode a cada cadena en los datos, excepto index y horas
                                        for j in range(len(course_data)):
                                            # Evita aplicar unidecode a index, hora de inicio y hora de fin
                                            if j not in [0, 8, 9]:
                                                if isinstance(course_data[j], str):
                                                    course_data[j] = unidecode(
                                                        course_data[j])

                                        data.append(course_data)
                                        index += 1

# Guarda los datos en un archivo CSV
with open('data/ugr_data.csv', 'w', newline='', encoding='utf-8') as csv_file:
    csv_writer = csv.writer(csv_file)
    csv_writer.writerows(data)

print('Datos guardados en ugr_data.csv')
