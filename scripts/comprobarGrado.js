function comprobarGrado(titulacion){
  // Queda quitar los en y que solo se pongan las carreras
  var entityMates = ['doble grado en informatica y matematicas', 'doble grado en ingenieria informatica y matematicas', 'doble grado en matematicas e informatica', 'doble grado en matematicas e ingenieria informatica', 'doble titulacion en informatica y matematicas', 'doble grado en matematicas e ingenieria informatica', 'doble titulacion en ingenieria informatica y matematicas', 'doble titulacion en matematicas e informatica', 'doble titulacion en matematicas e ingenieria informatica', 'doble titulacion en matematicas y informatica', 'doble titulacion en matematicas y ingenieria informatica', 'grado en informatica y matematicas', 'grado en ingenieria informatica y matematicas', 'grado en matematicas y informatica', 'grado en matematicas y ingenieria informatica', 'titulacion en informatica y matematicas', 'titulacion en ingenieria informatica y matematicas', 'titulacion en matematicas y informatica', 'titulacion en matematicas y ingenieria informatica'];
  var entityAde = ['doble grado en informatica y ade', 'doble grado en ingenieria informatica y ade', 'doble grado en ade e informatica', 'doble grado en ade e ingenieria informatica', 'doble titulacion en informatica y ade', 'doble grado en ade e ingenieria informatica', 'doble titulacion en ingenieria informatica y ade', 'doble titulacion en ade e informatica', 'doble titulacion en ade e ingenieria informatica', 'doble titulacion en ade y informatica', 'doble titulacion en ade y ingenieria informatica', 'grado en informatica y ade', 'grado en ingenieria informatica y ade', 'grado en ade y informatica', 'grado en ade y ingenieria informatica', 'titulacion en informatica y ade', 'titulacion en ingenieria informatica y ade', 'titulacion en ade y informatica', 'titulacion en ade y ingenieria informatica', 'doble grado en informatica y administracion y direccion de empresas', 'doble grado en ingenieria informatica y administracion y direccion de empresas', 'doble grado en administracion y direccion de empresas e informatica', 'doble grado en administracion y direccion de empresas e ingenieria informatica', 'doble titulacion en informatica y administracion y direccion de empresas', 'doble grado en administracion y direccion de empresas e ingenieria informatica', 'doble titulacion en ingenieria informatica y administracion y direccion de empresas', 'doble titulacion en administracion y direccion de empresas e informatica', 'doble titulacion en administracion y direccion de empresas e ingenieria informatica', 'doble titulacion en administracion y direccion de empresas y informatica', 'doble titulacion en administracion y direccion de empresas y ingenieria informatica', 'grado en informatica y administracion y direccion de empresas', 'grado en ingenieria informatica y administracion y direccion de empresas', 'grado en administracion y direccion de empresas y informatica', 'grado en administracion y direccion de empresas y ingenieria informatica', 'titulacion en informatica y administracion y direccion de empresas', 'titulacion en ingenieria informatica y administracion y direccion de empresas', 'titulacion en administracion y direccion de empresas y informatica', 'titulacion en administracion y direccion de empresas y ingenieria informatica'];
  var entityTeleco = ['teleco', 'telecomunicacion', 'telecomunicaciones', 'ingenieria de tecnologia de teleco', 'ingenieria de tecnologia de telecomunicacion', 'ingenieria de tecnologia de telecomunicaciones', 'ingenieria de tecnologia de'];
  var entityInfo = ['informatica', 'ingenieria informatica'];
  var respuesta = "";

  // Si el index es -1 quiere decir que no se se corresponde con ningun valor de la Entity
  if (!(entityInfo.indexOf(titulacion) === -1)) {
      respuesta = 1;
  }else if (!(entityTeleco.indexOf(titulacion) === -1)){
      respuesta = 2;
  }else if (!(entityMates.indexOf(titulacion) === -1)){
    respuesta = 3;
  }else if (!(entityAde.indexOf(titulacion) === -1)){
    respuesta = 4;
  } else{
    respuesta = 0;
  }
  
  return respuesta;
}
