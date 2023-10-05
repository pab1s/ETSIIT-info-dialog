function comprobarGrado(titulacion){
  const informaticaRegex = /\[ingenieria\] informatica/;
  const telecomunicacionesRegex = /\[ingenieria de tecnologia\[s\] de\] teleco\[municacion\[es\]\]/;
  const adeRegex = /administracion y direccion de empresas \| ade/;
  const dgiimRegex = /\[\[(doble) (grado | titulacion) [en]] (<informatica> [y] matematicas) | (matematicas [e|y] <informatica>)\]/;
  const dgiiadeRegex = /\[\[(doble) (grado | titulacion) [en]] (<informatica> [y] <ade>) | (<ade> [y] <informatica>)\]/;

  if (informaticaRegex.test(titulacion)) {
    return 1;
  } else if (telecomunicacionesRegex.test(titulacion)) {
    return 2;
  } else if (dgiimRegex.test(titulacion)) {
    return 3;
  } else if (dgiiadeRegex.test(titulacion)) {
    return 4;
  } else {
    return 0; // No coincide con ninguna 
  }
}


/*
  var entityMates = [''];
  var entityAde = ['administracion y direccion de empresas', 'ade'];
  var entityTeleco = ['teleco', 'telecomunicacion', 'telecomunicaciones', 'ingenieria de tecnologia de teleco', 'ingenieria de tecnologia de telecomunicacion', 'ingenieria de tecnologia de telecomunicaciones', 'ingenieria de tecnologia de'];
  var entityInfo = ['informatica', 'ingenieria informatica'];
  var respuesta = "";
  // Si el index es -1 quiere decir que no se se corresponde con ningun valor de la Entity
  if (entityFacultades.indexOf(fac) === -1) {
      // La ciudad NO es correcta
      respuesta = 0;
  
  }else{
      // La ciudad ES correcta
      respuesta = 1
  }
  
  return respuesta;
}
*/