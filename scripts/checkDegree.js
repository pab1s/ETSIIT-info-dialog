function checkDegree(degree) {
  const informatics = [
    "informatics",
    "computer science",
    "computer engineering",
    "bachelors degree in computer engineering",
    "bachelor in computer engineering",
    "bachelors degree in computer science"
  ];
  
  const telecommunications = [
    "teleco",
    "telecommunications",
    "bachelors degree in telecommunications",
    "bachelor in telecommunications"
  ];
  
  const business = [
    "business",
    "management",
    "administration",
    "informatics and business",
    "business and informatics",
    "informatics and business administration",
    "business administration and computer science",
    "computer science and business administration",
    "computer engineering and business administration",
    "business administration and computer engineering",
    "computer engineering and management",
    "computer engineering and business management",
    "bachelors degree in computer engineering and bachelors degree in business administration and management",
    "bachelors degree in computer engineering plus bachelors degree in business administration and management",
    "double degree in computer science and business administration",
    "double degree in computer engineering and business administration",
    "double degree in informatics and ade",
    "double degree in computer engineering and ade"
  ];
  
  const maths = [
    "maths",
    "mathematics",
    "informatics and maths",
    "informatics and mathematics",
    "computer science and maths",
    "computer engineering and maths",
    "computer science and mathematics",
    "computer engineering and mathematics",
    "double degree in computer engineering and mathematics",
    "double degree in computer engineering and maths",
    "double degree in mathematics and computer engineering",
    "bachelors degree in computer engineering and mathematics",
    "bachelors degree in computer engineering and bachelors degree in mathematics",
    "bachelors degree in computer engineering plus bachelors degree in mathematics"
  ];
  
  let response = 0;

  if (informatics.includes(degree)) {
    response = 1;
  } else if (telecommunications.includes(degree)) {
    response = 2;
  } else if (maths.includes(degree)) {
    response = 3;
  } else if (business.includes(degree)) {
    response = 4;
  }

  return response;
}
