const fs = require('fs');
const csvParser = require('csv-parser');

async function checkProfesores(asignatura, titulacion) {
    return new Promise((resolve, reject) => {
        let profesoresAsociados = new Set();

        fs.createReadStream('../data/ugr_data.csv')
            .pipe(csvParser({ separator: ',' }))
            .on('data', (row) => {
                if (row.Titulacion.trim() === asignatura && row.Asignatura.trim() === titulacion) {
                    profesoresAsociados.add(row.Profesor && row.Profesor.trim());
                }
            })
            .on('end', () => {
                if (profesoresAsociados.size > 0) {
                    let profesoresString = [...profesoresAsociados].join(', ');
                    if (profesoresAsociados.size > 1) {
                        const lastCommaIndex = profesoresString.lastIndexOf(', ');
                        profesoresString = `${profesoresString.substring(0, lastCommaIndex)} y${profesoresString.substring(lastCommaIndex + 1)}`;
                    }
                    resolve(profesoresString);
                } else {
                    resolve('Ningún profesor encontrado para la asignatura y titulación especificadas.');
                }
            })
            .on('error', (error) => {
                reject('Error al leer el archivo CSV: ' + error);
            });
    });
}

