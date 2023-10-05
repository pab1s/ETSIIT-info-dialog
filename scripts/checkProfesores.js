const fs = require('fs');
const csvParser = require('csv-parser');

function checkProfesores(asignatura, titulacion) {
    let profesoresAsociados = new Set();

    fs.createReadStream('../data/ugr_data.csv')
        .pipe(csvParser({ separator: ',' })) // Ajusta el delimitador según tu archivo CSV
        .on('data', (row) => {
            if(row.Titulacion.trim() === asignatura && row.Asignatura.trim() === titulacion){
                profesoresAsociados.add(row.Profesor && row.Profesor.trim());
            }
        })
        .on('end', () => {
            if (profesoresAsociados.size > 0) {
                console.log('Profesor(es) asociado(s) a la asignatura y titulación:');
                console.log(profesoresAsociados);
            } else {
                console.log('Ningún profesor encontrado para la asignatura y titulación especificadas.');
            }
        })
        .on('error', (error) => {
            console.error('Error al leer el archivo CSV:', error);
        });
}

// Ejemplo de uso
const asignatura = 'Grado en Ingenieria Informatica';
const titulacion = 'Inteligencia Artificial';
checkProfesores(asignatura, titulacion);
