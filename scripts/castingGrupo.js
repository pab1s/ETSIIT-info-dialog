function castingGrupo(grupoaelegir) {
  var numerosEnLetras = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno', 'veintidos', 'veintitres', 'veinticuatro', 'veinticinco', 'veintiseis', 'veintisiete', 'veintiocho', 'veintinueve'];
  var grupos = ['grupo a', 'grupo be', 'grupo ce', 'grupo de', 'grupo e', 'grupo efe', 'grupo ge', 'grupo ache', 'grupo i', 'grupo jota', 'grupo ka', 'grupo ele', 'grupo eme', 'grupo ene', 'grupo o', 'grupo pe', 'grupo cu', 'grupo erre', 'grupo ese', 'grupo te', 'grupo u', 'grupo uve', 'grupo uve doble', 'grupo equis', 'grupo i griega', 'grupo zeta'];
  var letrasMayus = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
  var respuesta = '';

  if (numerosEnLetras.indexOf(grupoaelegir) === -1) {
    if (grupos.indexOf(grupoaelegir) === -1) {
      respuesta = '-1'; // Return a string '-1' for non-matching values
    } else {
      respuesta = letrasMayus[grupos.indexOf(grupoaelegir)].toString();
    }
  } else {
    respuesta = numerosEnLetras.indexOf(grupoaelegir);
  }

  return respuesta;
}
