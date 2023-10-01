<?php
// Get the day of the week from the VXML POST request
$dayOfWeek = $_POST['dayOfWeek'];

// Perform a database query to retrieve the menu for the specified day
// Replace these with your database connection details
$serverName = "your_server_name";
$connectionOptions = array(
    "Database" => "menus",
    "Uid" => "your_username",
    "PWD" => "your_password"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die("Connection failed: " . sqlsrv_errors());
}

$sql = "SELECT menu FROM daily_menus WHERE day_of_week = ?";
$params = array($dayOfWeek);
$query = sqlsrv_query($conn, $sql, $params);

if ($query === false) {
    die("Query failed: " . sqlsrv_errors());
}

$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

if (!$row) {
    // If there's no menu for the specified day, you can provide a response accordingly
    $menuResponse = "I'm sorry, there is no menu available for $dayOfWeek.";
} else {
    // Get the menu from the database
    $menuResponse = $row['menu'];
}

// Output the menu as VoiceXML
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>
<vxml version="2.1" xmlns="http://www.w3.org/2001/vxml">
  <form>
    <block>
      <prompt>' . $menuResponse . '</prompt>
    </block>
  </form>
</vxml>';

// Close the database connection
sqlsrv_close($conn);
?>
