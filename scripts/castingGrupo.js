function castingGrupo(grupoaelegir){
  // Queda quitar los en y que solo se pongan las carreras
  var numerosEnLetras = ['cero','uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez','once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno', 'veintidos', 'veintitres', 'veinticuatro', 'veinticinco', 'veintiseis', 'veintisiete', 'veintiocho', 'veintinueve', 'treinta'];
  var respuesta = "";
 
  // Si el index es -1 quiere decir que no se se corresponde con ningun valor de la Entity
  if (numerosEnLetras.indexOf(grupoaelegir) === -1) {
    respuesta = grupoaelegir;
  }else{
    respuesta = numerosEnLetras.indexOf(grupoaelegir);
  }
  
  return respuesta;
 }
 