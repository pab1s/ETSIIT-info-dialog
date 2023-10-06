function comprobarGrado(titulacion){
  // Queda quitar los en y que solo se pongan las carreras
  var entityMates = ['doble grado en informatica y matematicas', 'doble grado en ingenieria informatica y matematicas', 'doble grado en matematicas e informatica', 'doble grado en matematicas e ingenieria informatica', 'doble titulacion en informatica y matematicas', 'doble grado en matematicas e ingenieria informatica', 'doble titulacion en ingenieria informatica y matematicas', 'doble titulacion en matematicas e informatica', 'doble titulacion en matematicas e ingenieria informatica', 'doble titulacion en matematicas y informatica', 'doble titulacion en matematicas y ingenieria informatica', 'grado en informatica y matematicas', 'grado en ingenieria informatica y matematicas', 'grado en matematicas y informatica', 'grado en matematicas y ingenieria informatica', 'titulacion en informatica y matematicas', 'titulacion en ingenieria informatica y matematicas', 'titulacion en matematicas y informatica', 'titulacion en matematicas y ingenieria informatica', 'doble grado informatica y matematicas', 'doble grado ingenieria informatica y matematicas', 'doble grado matematicas e informatica', 'doble grado matematicas e ingenieria informatica', 'doble titulacion informatica y matematicas', 'doble grado matematicas e ingenieria informatica', 'doble titulacion ingenieria informatica y matematicas', 'doble titulacion matematicas e informatica', 'doble titulacion matematicas e ingenieria informatica', 'doble titulacion matematicas y informatica', 'doble titulacion matematicas y ingenieria informatica', 'grado informatica y matematicas', 'grado ingenieria informatica y matematicas', 'grado matematicas y informatica', 'grado matematicas y ingenieria informatica', 'titulacion informatica y matematicas', 'titulacion ingenieria informatica y matematicas', 'titulacion matematicas y informatica', 'titulacion matematicas y ingenieria informatica', 'informatica y matematicas', 'ingenieria informatica y matematicas', 'matematicas e informatica', 'matematicas e ingenieria informatica', 'matematicas y informatica', 'matematicas y ingenieria informatica'];
  var entityAde1 = ['doble grado en informatica y ade', 'doble grado en ingenieria informatica y ade', 'doble grado en ade e informatica', 'doble grado en ade e ingenieria informatica', 'doble titulacion en informatica y ade', 'doble grado en ade e ingenieria informatica', 'doble titulacion en ingenieria informatica y ade', 'doble titulacion en ade e informatica', 'doble titulacion en ade e ingenieria informatica', 'doble titulacion en ade y informatica', 'doble titulacion en ade y ingenieria informatica', 'grado en informatica y ade', 'grado en ingenieria informatica y ade', 'grado en ade y informatica', 'grado en ade y ingenieria informatica', 'titulacion en informatica y ade', 'titulacion en ingenieria informatica y ade', 'titulacion en ade y informatica', 'titulacion en ade y ingenieria informatica', 'doble grado informatica y ade', 'doble grado ingenieria informatica y ade', 'doble grado ade e informatica', 'doble grado ade e ingenieria informatica', 'doble titulacion informatica y ade', 'doble grado ade e ingenieria informatica', 'doble titulacion ingenieria informatica y ade', 'doble titulacion ade e informatica', 'doble titulacion ade e ingenieria informatica', 'doble titulacion ade y informatica', 'doble titulacion ade y ingenieria informatica', 'grado informatica y ade', 'grado ingenieria informatica y ade', 'grado ade y informatica', 'grado ade y ingenieria informatica', 'titulacion informatica y ade', 'titulacion ingenieria informatica y ade', 'titulacion ade y informatica', 'titulacion ade y ingenieria informatica', 'informatica y ade', 'ingenieria informatica y ade', ' ade e informatica', ' ade e ingenieria informatica', ' ade y informatica', ' ade y ingenieria informatica', 'doble grado en informatica y ade', 'doble grado en ingenieria informatica y adminsitracion y direccion de empresas', 'doble grado en adminsitracion y direccion de empresas e informatica', 'doble grado en adminsitracion y direccion de empresas e ingenieria informatica', 'doble titulacion en informatica y adminsitracion y direccion de empresas', 'doble grado en adminsitracion y direccion de empresas e ingenieria informatica', 'doble titulacion en ingenieria informatica y adminsitracion y direccion de empresas', 'doble titulacion en adminsitracion y direccion de empresas e informatica'];
  var entityAde2 = ['doble titulacion en adminsitracion y direccion de empresas e ingenieria informatica', 'doble titulacion en adminsitracion y direccion de empresas y informatica', 'doble titulacion en adminsitracion y direccion de empresas y ingenieria informatica', 'grado en informatica y adminsitracion y direccion de empresas', 'grado en ingenieria informatica y adminsitracion y direccion de empresas', 'grado en adminsitracion y direccion de empresas y informatica', 'grado en adminsitracion y direccion de empresas y ingenieria informatica', 'titulacion en informatica y adminsitracion y direccion de empresas', 'titulacion en ingenieria informatica y adminsitracion y direccion de empresas', 'titulacion en adminsitracion y direccion de empresas y informatica', 'titulacion en adminsitracion y direccion de empresas y ingenieria informatica', 'doble grado informatica y adminsitracion y direccion de empresas', 'doble grado ingenieria informatica y adminsitracion y direccion de empresas', 'doble grado adminsitracion y direccion de empresas e informatica', 'doble grado adminsitracion y direccion de empresas e ingenieria informatica', 'doble titulacion informatica y adminsitracion y direccion de empresas', 'doble grado adminsitracion y direccion de empresas e ingenieria informatica', 'doble titulacion ingenieria informatica y adminsitracion y direccion de empresas', 'doble titulacion adminsitracion y direccion de empresas e informatica', 'doble titulacion adminsitracion y direccion de empresas e ingenieria informatica', 'doble titulacion adminsitracion y direccion de empresas y informatica', 'doble titulacion adminsitracion y direccion de empresas y ingenieria informatica', 'grado informatica y adminsitracion y direccion de empresas', 'grado ingenieria informatica y adminsitracion y direccion de empresas', 'grado adminsitracion y direccion de empresas y informatica', 'grado adminsitracion y direccion de empresas y ingenieria informatica', 'titulacion informatica y adminsitracion y direccion de empresas', 'titulacion ingenieria informatica y adminsitracion y direccion de empresas', 'titulacion adminsitracion y direccion de empresas y informatica', 'titulacion adminsitracion y direccion de empresas y ingenieria informatica', 'informatica y adminsitracion y direccion de empresas', 'ingenieria informatica y adminsitracion y direccion de empresas'];
  var entityAde3 = [, 'adminsitracion y direccion de empresas e informatica', 'adminsitracion y direccion de empresas e ingenieria informatica', 'adminsitracion y direccion de empresas y informatica', 'adminsitracion y direccion de empresas y ingenieria informatica'];
  var entityTeleco = ['teleco', 'telecomunicacion', 'telecomunicaciones', 'ingenieria de tecnologia de teleco', 'ingenieria de tecnologia de telecomunicacion', 'ingenieria de tecnologia de telecomunicaciones', 'ingenieria de tecnologias de teleco', 'ingenieria de tecnologias de telecomunicacion', 'ingenieria de tecnologias de telecomunicaciones'];
  var entityInfo = ['informatica', 'ingenieria informatica'];
  var respuesta = "";
 
  // Si el index es -1 quiere decir que no se se corresponde con ningun valor de la Entity
  if (!(entityInfo.indexOf(titulacion) === -1)) {
    respuesta = 1;
  }else if (!(entityTeleco.indexOf(titulacion) === -1)){
    respuesta = 2;
  }else if (!(entityMates.indexOf(titulacion) === -1)){
   respuesta = 3;
  }else if (!((entityAde1.indexOf(titulacion) === -1) && (entityAde2.indexOf(titulacion) === -1) && (entityAde3.indexOf(titulacion) === -1))){
   respuesta = 4;
  } else{
   respuesta = 0;
  }
  
  return respuesta;
 }
 