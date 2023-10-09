/**
 * Checks if a given degree matches a list of predefined degrees.
 * @param {string} degree - The degree to check.
 * @returns {number} - A number representing the type of degree:
 * 0 - Unknown degree
 * 1 - Informatics degree
 * 2 - Telecommunications degree
 * 3 - Maths degree
 * 4 - Business degree
 */
function checkDegree(degree) {
  var informatics = [
    'informatics',
    'computer science',
    'computer engineering',
    'bachelors degree in computer engineering',
    'bachelor in computer engineering',
    'bachelors degree in computer science'
  ];
  
  var telecommunications = [
    'teleco',
    'telecommunications',
    'bachelors degree in telecommunications',
    'bachelor in telecommunications'
  ];
  
  var business = [
    'business',
    'management',
    'administration',
    'informatics and business',
    'business and informatics',
    'informatics and business administration',
    'business administration and computer science',
    'computer science and business administration',
    'computer engineering and business administration',
    'business administration and computer engineering',
    'computer engineering and management',
    'computer engineering and business management',
    'bachelors degree in computer engineering and bachelors degree in business administration and management',
    'bachelors degree in computer engineering plus bachelors degree in business administration and management',
    'double degree in computer science and business administration',
    'double degree in computer engineering and business administration',
    'double degree in informatics and ade',
    'double degree in computer engineering and ade'
  ];
  
  var maths = [
    'maths',
    'mathematics',
    'informatics and maths',
    'informatics and mathematics',
    'computer science and maths',
    'computer engineering and maths',
    'computer science and mathematics',
    'computer engineering and mathematics',
    'double degree in computer engineering and mathematics',
    'double degree in computer engineering and maths',
    'double degree in mathematics and computer engineering',
    'bachelors degree in computer engineering and mathematics',
    'bachelors degree in computer engineering and bachelors degree in mathematics',
    'bachelors degree in computer engineering plus bachelors degree in mathematics'
  ];
  
  var response = 0;

  // Si el index es -1 quiere decir que no se se corresponde con ningun valor de la Entity
  if (!(informatics.indexOf(degree) === -1)) {
    response = 1;
  }else if (!(telecommunications.indexOf(degree) === -1)){
    response = 2;
  }else if (!(maths.indexOf(degree) === -1)){
   response = 3;
  }else if (!(business.indexOf(degree) === -1)){
   response = 4;
  } else{
   response = 0;
  }

  return response;
}
