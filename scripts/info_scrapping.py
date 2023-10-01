import requests
from bs4 import BeautifulSoup

# URL de la página web
url = 'https://www.ugr.es/estudiantes/grados/grado-ingenieria-informatica'

# Realizar una solicitud GET a la página
response = requests.get(url)

# Parsear el contenido HTML de la página
soup = BeautifulSoup(response.text, 'html.parser')

# Obtener el encabezado h1 que es el nombre de la titulación
nombre_titulacion = soup.find('h1', class_='page-title').text.strip()

print(f'Nombre de la titulación: {nombre_titulacion}')

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
    # Obtener el número de curso
    numero_curso = seccion_curso.find('h2').text.strip()
    print(f'Número de curso: {numero_curso}')
    
    # Obtener las asignaturas por semestre
    tabla_semestres = seccion_curso.find_all('table', class_='tabla-semestre')
    
    for tabla in tabla_semestres:
        semestre = tabla.find('caption').text.strip()
        print(f'Semestre: {semestre}')
        
        asignaturas = tabla.find_all('td', class_='asignatura')
        
        for asignatura in asignaturas:
            nombre_asignatura = asignatura.a.text.strip()
            print(f'\nAsignatura: {nombre_asignatura}')
            
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
                print(f'Profesorado {tipo_profesorado}:')
                
                profesores = profesorado.find_all('li', class_='profesor')
                for profesor in profesores:
                    nombre_profesor = profesor.a.text.strip()
                    grupos = profesor.find('span', class_='grupos').text.strip()
                    
                    # Eliminar líneas en blanco y espacios adicionales
                    grupos = ' '.join(grupos.split())
                    
                    print(f'{nombre_profesor} --> {grupos}')
            
            # Encontrar la sección de horarios
            seccion_horarios = soup_asignatura.find('div', class_='horario')

            if seccion_horarios:
                print('Horarios:')
                
                # Buscar todas las filas de horarios
                filas_horarios = seccion_horarios.find_all('tr')
                
                # Obtener los nombres de los días de la semana
                dias_semana = []
                for dia in filas_horarios[0].find_all('div', class_='dia-red'):
                    dia_abreviatura = dia.text.strip()
                    dia_completo = dias_abreviaturas.get(dia_abreviatura, 'Día desconocido')
                    dias_semana.append(dia_completo)
                
                # Iterar a través de las filas de horarios
                for fila in filas_horarios[1:]:
                    
                    # Obtener las celdas de horario
                    celdas_horario = fila.find_all('td')
                    
                    # Iterar a través de las celdas de horario
                    for i, celda in enumerate(celdas_horario):
                        if celda.find('div', class_='clase'):
                            grupo = celda.find('div', class_='grupo').text.strip()
                            otros_datos = celda.find('div', class_='otros-datos').text.strip()
                            
                            # Extraer información del horario
                            info_horario = otros_datos.split('\n')
                            aula = info_horario[0].split(': ')[1]
                            fechas_horario = info_horario[2].split(': ')[1]
                            horario = info_horario[3].split(': ')[1]
                            
                            # Imprimir la información del horario
                            print(f' {grupo}: {dias_semana[i]}, Aula {aula}, {horario}')
    
    print('\n')  # Agregar una línea en blanco entre los cursos
