<?php
  // Get the day of the week from the VXML POST request
  $profesor = $_POST['profesor'];
  /*
  // Perform a database query to retrieve the menu for the specified day
  // Replace these with your database connection details
  $serverName = "sql11.freesqldatabase.com";
  $connectionOptions = array(
    "Database" => "sql11650278",
    "Uid" => "sql11650278",
    "PWD" => "Akie4puyXm"
  );

  $conn = sqlsrv_connect($serverName, $connectionOptions);

  if (!$conn) {
    die("Connection failed: " . sqlsrv_errors());
  }

  $sql = "SELECT asignatura FROM etsiit_courses WHERE profesor = ?";
  $params = array($profesor);
  $query = sqlsrv_query($conn, $sql, $params);

  if ($query === false) {
    die("Query failed: " . sqlsrv_errors());
  }

  $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

  if (!$row) {
    // If there's no menu for the specified day, you can provide a response accordingly
    $response = "Disculpa, no hemos encontrado ninguna asignatura impartida por $profesor.";
  } else {
    // Get the menu from the database
    // $response = $row['asignatura'];
    $response = "Hemos encontrado su respuesta";
  }
  */
  // Output the menu as VoiceXML
  echo("<?vxml version=\"1.0\"?>\n");
  $string = "Hello XIMO! How are you?";

  // Close the database connection
  // sqlsrv_close($conn);
?>
<vxml version="2.1" xmlns="http://www.w3.org/2001/vxml">
  <form>
    <block>
      <prompt><?=htmlspecialchars($string)?>.</prompt>
    </block>
  </form>
</vxml>