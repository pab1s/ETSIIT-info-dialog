<?php
// Set the content type to VoiceXML
header('Content-type: application/voicexml+xml');

// Get the input parameters from the VXML POST request
$titulacion = isset($_POST['titulacion']) ? $_POST['titulacion'] : '';
$asignatura = isset($_POST['asignatura']) ? $_POST['asignatura'] : '';
$curso = isset($_POST['curso']) ? $_POST['curso'] : '';
$profesor = isset($_POST['profesor']) ? $_POST['profesor'] : '';
$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';

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
if (!empty($titulacion) && !empty($asignatura)) {
    // Titulacion and Asignatura -> Profesores y Grupos
    $sql = "SELECT profesor, grupo FROM ugr_courses WHERE titulacion = :titulacion AND asignatura = :asignatura";
    $params = [':titulacion' => $titulacion, ':asignatura' => $asignatura];
    $results = executeQuery($conn, $sql, $params);

    if (count($results) > 0) {
        $response = "Los profesores y grupos para $titulacion y $asignatura son:";
        foreach ($results as $row) {
            $response .= " Profesor: " . $row['profesor'] . ", Grupo: " . $row['grupo'];
        }
    } else {
        $response = "Lo siento, no se encontraron resultados para $titulacion y $asignatura.";
    }
} elseif (!empty($titulacion) && !empty($profesor)) {
    // Titulacion and Profesor -> Asignaturas y Grupos
    $sql = "SELECT asignatura, grupo FROM ugr_courses WHERE titulacion = :titulacion AND profesor = :profesor";
    $params = [':titulacion' => $titulacion, ':profesor' => $profesor];
    $results = executeQuery($conn, $sql, $params);

    if (count($results) > 0) {
        $response = "Las asignaturas y grupos para $titulacion y el profesor $profesor son:";
        foreach ($results as $row) {
            $response .= " Asignatura: " . $row['asignatura'] . ", Grupo: " . $row['grupo'];
        }
    } else {
        $response = "Lo siento, no se encontraron resultados para $titulacion y el profesor $profesor.";
    }
} elseif (!empty($titulacion) && !empty($asignatura) && !empty($grupo)) {
    // Titulacion, Asignatura, and Grupo -> Horario
    $sql = "SELECT dia_de_la_semana, hora_inicio, hora_fin FROM ugr_courses WHERE titulacion = :titulacion AND asignatura = :asignatura AND grupo = :grupo";
    $params = [':titulacion' => $titulacion, ':asignatura' => $asignatura, ':grupo' => $grupo];
    $results = executeQuery($conn, $sql, $params);

    if (count($results) > 0) {
        $response = "El horario para $titulacion, $asignatura y el grupo $grupo es:";
        foreach ($results as $row) {
            $response .= " Día: " . $row['dia_de_la_semana'] . ", Hora Inicio: " . $row['hora_inicio'] . ", Hora Fin: " . $row['hora_fin'];
        }
    } else {
        $response = "Lo siento, no se encontraron resultados para $titulacion, $asignatura y el grupo $grupo.";
    }
} elseif (!empty($titulacion) && !empty($curso)) {
    // Titulacion and Curso -> Asignaturas
    $sql = "SELECT DISTINCT asignatura FROM ugr_courses WHERE titulacion = :titulacion AND curso = :curso";
    $params = [':titulacion' => $titulacion, ':curso' => $curso];
    $results = executeQuery($conn, $sql, $params);

    if (count($results) > 0) {
        $response = "Las asignaturas para $titulacion y el curso $curso son:";
        foreach ($results as $row) {
            $response .= " " . $row['asignatura'];
        }
    } else {
        $response = "Lo siento, no se encontraron asignaturas para $titulacion y el curso $curso.";
    }
} else {
    $response = "Por favor, proporciona parámetros válidos para la consulta.";
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
