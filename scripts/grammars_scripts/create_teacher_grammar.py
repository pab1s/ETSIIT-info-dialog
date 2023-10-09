import csv
from unidecode import unidecode

def create_teacher_grammar():
    """
    Reads the names of teachers from a CSV file and stores them in a set to avoid duplicates.
    Then creates a .jsgf file with the unique names of teachers without accents.
    """
    # Leer los nombres de profesores desde el archivo CSV y almacenarlos en un conjunto para evitar duplicados
    profesores_set = set()

    with open('ugr_data.csv', 'r', newline='', encoding='utf-8') as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            profesor = row['profesor']
            # Aplicar unidecode para eliminar tildes y caracteres especiales
            profesor_sin_tildes = unidecode(profesor)
            # Agregar el profesor al conjunto
            profesores_set.add(profesor_sin_tildes.strip())  # Eliminar espacios en blanco al principio y al final del nombre

    # Crear el archivo .jsgf con los nombres de profesores sin repeticiones y sin tildes
    with open('profesores.jsgf', 'w', encoding='utf-8') as jsgf_file:
        jsgf_file.write('''
    #JSGF V1.0;

    grammar profesores;

    public <profesores> = {}
    '''.format(' | '.join(profesores_set)))

    print("Archivo profesores.jsgf creado exitosamente con los nombres de profesores sin repeticiones y sin tildes.")
