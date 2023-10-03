import requests
from bs4 import BeautifulSoup
import csv

# URL of the webpage
url = 'https://www.ugr.es/estudiantes/grados/grado-ingenieria-informatica'

# Perform a GET request to the page
response = requests.get(url)

# Parse the HTML content of the page
soup = BeautifulSoup(response.text, 'html.parser')

# Create a data structure to store the extracted information
data = []

# Define the CSV file header
csv_header = [
    "Titulacion",
    "Asignatura",
    "Curso",
    "Semestre",
    "Grupo",
    "Profesor",
    "Dia de la semana",
    "Hora inicio",
    "Hora fin"
]

# Add the header to the data list
data.append(csv_header)

# Obtain the h1 header, which is the name of the degree program
nombre_titulacion = soup.find('h1', class_='page-title').text.strip()

# Find all course sections
secciones_cursos = soup.find_all('div', class_='block-views-blockpeople-subject-asignatura-persona')

# Dictionary to map day abbreviations to full names
dias_abreviaturas = {
    'L': 'Lunes',
    'M': 'Martes',
    'X': 'Miércoles',
    'J': 'Jueves',
    'V': 'Viernes'
}

# Create index
index = 0

# Iterate through course sections
for seccion_curso in secciones_cursos:
    # Get the course number
    numero_curso = seccion_curso.find('h2').text.strip()

    # Get the subjects by semester
    tabla_semestres = seccion_curso.find_all('table', class_='tabla-semestre')

    for tabla in tabla_semestres:
        semestre = tabla.find('caption').text.strip()

        asignaturas = tabla.find_all('td', class_='asignatura')

        for asignatura in asignaturas:
            # Get the link to the subject
            enlace_asignatura = asignatura.a['href']

            # Perform a GET request to the subject link
            response_asignatura = requests.get(enlace_asignatura)

            # Parse the HTML content of the subject page
            soup_asignatura = BeautifulSoup(response_asignatura.text, 'html.parser')

            # Find the professor section
            seccion_profesorado = soup_asignatura.find_all('div', class_='profesorado-asignatura')

            for profesorado in seccion_profesorado:
                tipo_profesorado = profesorado.find('h3').text.strip()
                profesores = profesorado.find_all('li', class_='profesor')

                for profesor in profesores:
                    nombre_profesor = profesor.a.text.strip()
                    grupos = profesor.find('span', class_='grupos').text.strip().split()[-1]

                    # Find the schedule section
                    seccion_horarios = soup_asignatura.find('div', class_='horario')

                    if seccion_horarios:
                        # Find all schedule rows
                        filas_horarios = seccion_horarios.find_all('tr')

                        # Get the names of the days of the week
                        dias_semana = []
                        for dia in filas_horarios[0].find_all('div', class_='dia-red'):
                            dia_abreviatura = dia.text.strip()
                            dias_semana.append(dia_abreviatura)

                        # Iterate through schedule rows
                        for fila in filas_horarios[1:]:
                            # Get the schedule cells
                            celdas_horario = fila.find_all('td')

                            # Iterate through schedule cells
                            for i, celda in enumerate(celdas_horario):
                                if celda.find('div', class_='clase'):
                                    grupo = celda.find('div', class_='grupo').text.strip().split(' ')[1]
                                    otros_datos = celda.find('div', class_='otros-datos').text.strip()
                                    info_horario = otros_datos.split('\n')
                                    aula = info_horario[0].split(': ')[1]
                                    fechas_horario = info_horario[2].split(': ')[1]
                                    horario = info_horario[3].split(': ')[1]
                                    horario = horario.split(' ')[1::2]

                                    # Create a list with the data to be saved in CSV format
                                    course_data = [
                                        index,
                                        nombre_titulacion,
                                        asignatura.text.strip(),
                                        numero_curso,
                                        semestre,
                                        grupo,
                                        tipo_profesorado,
                                        nombre_profesor,
                                        dias_abreviaturas[dias_semana[i]],
                                        horario[0]+":00",
                                        horario[1]+":00"
                                    ]

                                    data.append(course_data)
                                    index += 1

# Save data to a CSV file
with open('ugr_data.csv', 'w', newline='', encoding='utf-8') as csv_file:
    csv_writer = csv.writer(csv_file)
    csv_writer.writerows(data)

print('Data saved to ugr_data.csv')
