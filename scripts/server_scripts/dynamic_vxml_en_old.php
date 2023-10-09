/**
 * 
 * OLD FILE
 * This script handles a VoiceXML POST request and returns a response based on the input parameters in english.
 * It connects to a MySQL database and executes queries to retrieve information about courses, professors, and groups.
 * The response is formatted in VoiceXML and includes information about the requested course, professor, and groups.
 * 
 * @param string $grado The degree program (e.g. "Computer Science") requested by the user
 * @param string $asignatura The course name (e.g. "Database Systems") requested by the user
 * @param string $curso The course level (e.g. "Undergraduate") requested by the user
 * @param string $profesor The professor name (e.g. "John Smith") requested by the user
 * @param string $grupo The group type (e.g. "Theory" or "Laboratory") requested by the user
 * 
 * @return string The VoiceXML response containing information about the requested course, professor, and groups
 */
<?php
// Set the content type to VoiceXML
header('Content-type: application/voicexml+xml');

// Get the input parameters from the VXML POST request
$grado = isset($_POST['grado']) ? $_POST['grado'] : '';
$asignatura = isset($_POST['asignatura']) ? $_POST['asignatura'] : '';
$curso = isset($_POST['curso']) ? $_POST['curso'] : '';
$profesor = isset($_POST['profesor']) ? $_POST['profesor'] : '';
$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';

// Database connection details
$serverName = "sql11.freesqldatabase.com";
$database = "sql11650278";
$username = "sql11650278";
$password = "Akie4puyXm";

// Initialize the response
$response = "";
$goodbye = "Thank you for using the service. Goodbye.";

// Connected to the database
$connected = true;

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // die("Connection failed: " . $e->getMessage());
    $response = "Sorry, the server is overloaded right now. Try again later. Connection failed: " . $e->getMessage();
    $connected = false;
}

// Function to execute a query and return results
function executeQuery($conn, $sql, $params) {
    $stmt = $conn->prepare($sql);
    foreach ($params as $param => $value) {
        $stmt->bindValue($param, $value, PDO::PARAM_STR);
    }
    $stmt->execute();

    $results = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $results[] = $row;
    }
    return $results;
}

// Connected to the database
if ($connected) {

    // Handle different query scenarios based on input parameters
    if (!empty($grado) && !empty($asignatura) && empty($grupo)) {
        // Titulacion and Asignatura -> Profesores y Grupos
        $sql = "SELECT DISTINCT profesor, grupo FROM etsiit_courses_en WHERE titulacion = :grado AND asignatura = :asignatura";
        $params = [':grado' => $grado, ':asignatura' => $asignatura];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "The professors and groups for $grado and $asignatura are:";
            foreach ($results as $row) {
                $response .= " Professor: " . $row['profesor'] . ", Group: " . $row['grupo'];
            }
        } else {
            $response = "Sorry, any result found for $grado and $asignatura.";
        }
    } elseif (!empty($grado) && !empty($profesor)) {
        // Titulacion and Profesor -> Asignaturas y Grupos
        $sql = "SELECT DISTINCT asignatura, grupo FROM etsiit_courses_en WHERE titulacion = :grado AND profesor = :profesor";
        $params = [':grado' => $grado, ':profesor' => $profesor];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "The subjects and groups for $grado and the professor $profesor are:";
            foreach ($results as $row) {
                $response .= " Subject: " . $row['asignatura'] . ", Group: " . $row['grupo'];
            }
        } else {
            $response = "Sorry, any result found for $grado and the professor $profesor.";
        }
    } elseif (!empty($grado) && !empty($asignatura) && !empty($grupo)) {
        // Titulacion, Asignatura, and Grupo -> Horario
        $sql = "SELECT DISTINCT dia_de_la_semana, TIME_FORMAT(hora_inicio, '%H:%i') AS hora_inicio, TIME_FORMAT(hora_fin, '%H:%i') AS hora_fin FROM etsiit_courses_en WHERE titulacion = :grado AND asignatura = :asignatura AND grupo = :grupo";
        $params = [':grado' => $grado, ':asignatura' => $asignatura, ':grupo' => $grupo];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "The schedule for $grado, $asignatura and the group $grupo is:";
            foreach ($results as $row) {
                $response .= " Day: " . $row['dia_de_la_semana'] . ", Beginning time: " . $row['hora_inicio'] . ", Finishing time: " . $row['hora_fin'];
            }
        } else {
            $response = "Sorry, any result found for $grado, $asignatura and the group $grupo.";
        }
    } elseif (!empty($grado) && !empty($curso)) {
        // Titulacion and Curso -> Asignaturas
        $sql = "SELECT DISTINCT asignatura FROM etsiit_courses_en WHERE titulacion = :grado AND curso = :curso";
        $params = [':grado' => $grado, ':curso' => $curso];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "The subjects for $grado and the year $curso are:";
            foreach ($results as $row) {
                $response .= " " . $row['asignatura'];
            }
        } else {
            $response = "Sorry, any result found for $grado yand the year $curso.";
        }
    } else {
        $response = "Please, give valid parameters for the query.";
    }
}

// Output the response as VoiceXML
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<vxml version="2.1" xml:lang="en-EN" xmlns="http://www.w3.org/2001/vxml">';
echo '<form>';
echo '<block>';
echo "<prompt>$response</prompt>";
echo "<prompt>$goodbye</prompt>";
echo '</block>';
echo '</form>';
echo '</vxml>';
?>
