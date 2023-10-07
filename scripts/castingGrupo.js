function castingGrupo(grupoaelegir){
  // Queda quitar los en y que solo se pongan las carreras
  var numerosEnLetras = ['cero','uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez','once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno', 'veintidos', 'veintitres', 'veinticuatro', 'veinticinco', 'veintiseis', 'veintisiete', 'veintiocho', 'veintinueve', 'treinta'];
  var letrasMayus = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
  var grupos = ['grupo a', 'grupo be', 'grupo ce', 'grupo de', 'grupo e', 'grupo efe', 'grupo ge', 'grupo ache', 'grupo i', 'grupo jota', 'grupo ka', 'grupo ele', 'grupo eme', 'grupo ene', 'grupo o', 'grupo pe', 'grupo cu', 'grupo erre', 'grupo ese', 'grupo te', 'grupo u', 'grupo uve', 'grupo uve doble', 'grupo equis', 'grupo i griega', 'grupo zeta']
  var respuesta = "";
 
  // Si el index es -1 quiere decir que no se se corresponde con ningun valor de la Entity
  if (numerosEnLetras.indexOf(grupoaelegir) === -1) {
    respuesta = grupoaelegir;
  }else{
    respuesta = letrasMayus[grupos.indexOf(grupoaelegir)];
  }
  
  return respuesta;
 }
 