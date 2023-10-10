/**
 * Recognizes the degree based on the given text using regular expressions.
 * @param {string} texto - The text to recognize the degree from.
 * @returns {string} - The recognized degree ("dgiim", "dgiiade", "informatica", "teleco", or "error").
 */
function reconocerTitulacion(texto) {
  // Expresiones regulares para reconocer las titulaciones
  const regexDGIIM = /((doble )?grado|titulacion( en)?)?(ingenieria )?informatica y matematicas|matematicas(e| y)?(ingenieria )?informatica/i;
  const regexDGIIADE = /((doble )?grado|titulacion( en)?)?(ingenieria )?informatica y (administracion y direccion de empresas|ade)|(administracion y direccion de empresas|ade) y (ingenieria )?informatica/i;
  const regexInformatica = /(ingenieria )?informatica/i;
  const regexTelecomunicaciones = /(ingenieria de tecnologia(s)?(( de)|( en))? teleco(municacion(es)?)?)/i;
  const regexADE = /(administracion y direccion de empresas|ade)/i;

  if (regexDGIIM.test(texto)) {
      return "dgiim";
  } else if (regexDGIIADE.test(texto)) {
      return "dgiiade";
  } else if (regexInformatica.test(texto)) {
      return "informatica";
  } else if (regexTelecomunicaciones.test(texto)) {
      return "teleco";
  } else {
      return "error"; // Si no se reconoce ninguna titulación, devolvemos 'error'
  }
}

// Ejemplo de uso
const texto = "teleco";
const nombreTitulacion = reconocerTitulacion(texto);

console.log("Titulación:", nombreTitulacion);
