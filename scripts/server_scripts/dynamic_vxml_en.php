<?php
// Set the content type to VoiceXML
header('Content-type: application/voicexml+xml');

// Get the input parameters from the VXML POST request
$grado = isset($_POST['grado']) ? $_POST['grado'] : 'Bachelor\'S Degree in Computer Engineering and Bachelor\'S Degree in Mathematics';
$asignatura = isset($_POST['asignatura']) ? $_POST['asignatura'] : 'Programming Methodology';
$curso = isset($_POST['curso']) ? $_POST['curso'] : '';
$profesor = isset($_POST['profesor']) ? $_POST['profesor'] : '';
$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : 'A';

// Database connection details
$serverName = "sql11.freesqldatabase.com";
$database = "sql11650278";
$username = "sql11650278";
$password = "Akie4puyXm";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Initialize the response
$response = "";

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

// Handle different query scenarios based on input parameters
if (!empty($grado) && !empty($asignatura) && empty($grupo)) {
    // Titulacion and Asignatura -> Profesores y Grupos
    $sql = "SELECT DISTINCT profesor, grupo FROM etsiit_courses WHERE titulacion = :grado AND asignatura = :asignatura";
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
    $sql = "SELECT DISTINCT asignatura, grupo FROM etsiit_courses WHERE titulacion = :grado AND profesor = :profesor";
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
    $sql = "SELECT DISTINCT dia_de_la_semana, TIME_FORMAT(hora_inicio, '%H:%i') AS hora_inicio, TIME_FORMAT(hora_fin, '%H:%i') AS hora_fin FROM etsiit_courses WHERE titulacion = :grado AND asignatura = :asignatura AND grupo = :grupo";
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
    $sql = "SELECT DISTINCT asignatura FROM etsiit_courses WHERE titulacion = :grado AND curso = :curso";
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

// Output the response as VoiceXML
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<vxml version="2.1" xml:lang="en-EN" xmlns="http://www.w3.org/2001/vxml">';
echo '<form>';
echo '<block>';
echo "<prompt>$response</prompt>";
echo '</block>';
echo '</form>';
echo '</vxml>';
?>
