function castingGroup(chosenGroup) {
  var numbersInLetters = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen', 'twenty', 'twenty-one', 'twenty-two', 'twenty-three', 'twenty-four', 'twenty-five', 'twenty-six', 'twenty-seven', 'twenty-eight', 'twenty-nine', 'thirty'];
  const groups = ['group a', 'group b', 'group c', 'group d', 'group e', 'group f', 'group g', 'group h', 'group i', 'group j', 'group k', 'group l', 'group m', 'group n', 'group o', 'group p', 'group q', 'group r', 'group s', 'group t', 'group u', 'group v', 'group w', 'group x', 'group y', 'group z'];
  var lettersCapital = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
  var response = '';

  if (numbersInLetters.indexOf(chosenGroup) === -1) {
    if (groups.indexOf(chosenGroup) === -1) {
      response = '-1'; // Return a string '-1' for non-matching values
    } else {
      response = lettersCapital[groups.indexOf(chosenGroup)].toString();
    }
  } else {
    response = numbersInLetters.indexOf(chosenGroup);
  }

  return response;
}

