<?php
// Set the content type to VoiceXML
header('Content-type: application/voicexml+xml');

// Get the input parameters from the VXML POST request
$profesor = isset($_POST['profesor']) ? $_POST['profesor'] : 'Pablo Mesejo Santiago';

// Connect to the database
$serverName = "sql11.freesqldatabase.com";
$database = "sql11650278";
$username = "sql11650278";
$password = "Akie4puyXm";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully to MySQL"; // Commented out for cleaner output
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Use prepared statement to avoid SQL injection
try {
    $sql = "SELECT DISTINCT asignatura FROM etsiit_courses WHERE profesor = :profesor";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':profesor', $profesor, PDO::PARAM_STR);
    $stmt->execute();

    $coursesFound = false; // Initialize a flag to track if courses were found
    $courseList = array(); // Initialize an array to store course names

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Process each row of data
        $courseList[] = $row['asignatura']; // Add the course to the list
        $coursesFound = true; // Set the flag to true if at least one course is found
    }

    if (!$coursesFound) {
        // If there are no results for the specified professor, provide a response accordingly
        $response = "Disculpa, no hemos encontrado ninguna asignatura impartida por $profesor.";
    } else {
        // If courses were found, set the response to include the list of courses
        $courseListStr = implode(", ", $courseList); // Convert the array to a comma-separated string
        $response = "Hemos encontrado asignatura(s) impartida(s) por $profesor. Las asignaturas son: $courseListStr.";
    }
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

// Output the response as VoiceXML
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<vxml version="2.1" xml:lang="es-ES" xmlns="http://www.w3.org/2001/vxml">';
echo '<form>';
echo '<block>';
echo "<prompt>$response</prompt>";
echo '</block>';
echo '</form>';
echo '</vxml>';
?>
