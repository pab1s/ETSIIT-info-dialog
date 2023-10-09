import csv
from unidecode import unidecode

def create_asignaturas_grammar():
    """
    Reads the names of subjects from a CSV file and stores them in a set to avoid duplicates.
    Then creates a .jsgf file with the subject names without duplicates and without accents.
    """
    # Leer los nombres de asignaturas desde el archivo CSV y almacenarlos en un conjunto para evitar duplicados
    asignaturas_set = set()

    with open('ugr_data.csv', 'r', newline='', encoding='utf-8') as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            asignatura = row['asignatura']
            # Aplicar unidecode para eliminar tildes y caracteres especiales
            asignatura_sin_tildes = unidecode(asignatura)
            # Agregar el profesor al conjunto
            asignaturas_set.add(asignatura_sin_tildes.strip())  # Eliminar espacios en blanco al principio y al final del nombre

    # Crear el archivo .jsgf con los nombres de asignaturas sin repeticiones y sin tildes
    with open('asignaturas.jsgf', 'w', encoding='utf-8') as jsgf_file:
        jsgf_file.write('''
    #JSGF V1.0;

    grammar asignaturas;

    public <asignaturas> = {}
    '''.format(' | '.join(asignaturas_set)))

    print("Archivo asignaturas.jsgf creado exitosamente con los nombres de asignaturas sin repeticiones y sin tildes.")
