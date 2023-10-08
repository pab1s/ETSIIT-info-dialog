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

// Connected to the database
$connected = true;

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // die("Connection failed: " . $e->getMessage());
    $response = "Lo siento, el servidor está sobrecargado en este momento. Inténtalo de nuevo más tarde. Connection failed: " . $e->getMessage();
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
        $sql = "SELECT DISTINCT profesor, grupo FROM etsiit_courses WHERE titulacion = :grado AND asignatura = :asignatura";
        $params = [':grado' => $grado, ':asignatura' => $asignatura];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "Los profesores y grupos para $grado y $asignatura son:";
            foreach ($results as $row) {
                $response .= " Profesor: " . $row['profesor'] . ", Grupo: " . $row['grupo'];
            }
        } else {
            $response = "Lo siento, no se encontraron resultados para $grado y $asignatura.";
        }
    } elseif (!empty($grado) && !empty($profesor)) {
        // Titulacion and Profesor -> Asignaturas y Grupos
        $sql = "SELECT DISTINCT asignatura, grupo FROM etsiit_courses WHERE titulacion = :grado AND profesor = :profesor";
        $params = [':grado' => $grado, ':profesor' => $profesor];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "Las asignaturas y grupos para $grado y el profesor $profesor son:";
            foreach ($results as $row) {
                $response .= " Asignatura: " . $row['asignatura'] . ", Grupo: " . $row['grupo'];
            }
        } else {
            $response = "Lo siento, no se encontraron resultados para $grado y el profesor $profesor.";
        }
    } elseif (!empty($grado) && !empty($asignatura) && !empty($grupo)) {
        // Titulacion, Asignatura, and Grupo -> Horario
        $sql = "SELECT DISTINCT dia_de_la_semana, TIME_FORMAT(hora_inicio, '%H:%i') AS hora_inicio, TIME_FORMAT(hora_fin, '%H:%i') AS hora_fin FROM etsiit_courses WHERE titulacion = :grado AND asignatura = :asignatura AND grupo = :grupo";
        $params = [':grado' => $grado, ':asignatura' => $asignatura, ':grupo' => $grupo];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "El horario para $grado, $asignatura y el grupo $grupo es:";
            foreach ($results as $row) {
                $response .= " Dia: " . $row['dia_de_la_semana'] . ", Hora Inicio: " . $row['hora_inicio'] . ", Hora Fin: " . $row['hora_fin'];
            }
        } else {
            $response = "Lo siento, no se encontraron resultados para $grado, $asignatura y el grupo $grupo.";
        }
    } elseif (!empty($grado) && !empty($curso)) {
        // Titulacion and Curso -> Asignaturas
        $sql = "SELECT DISTINCT asignatura FROM etsiit_courses WHERE titulacion = :grado AND curso = :curso";
        $params = [':grado' => $grado, ':curso' => $curso];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "Las asignaturas para $grado y el curso $curso son:";
            foreach ($results as $row) {
                $response .= " " . $row['asignatura'];
            }
        } else {
            $response = "Lo siento, no se encontraron asignaturas para $grado y el curso $curso.";
        }
    } else {
        $response = "Por favor, proporciona parámetros válidos para la consulta.";
    }
}

// Output the response as VoiceXML
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<vxml version="2.1" xml:lang="es-ES" xmlns="http://www.w3.org/2001/vxml">';
echo '<form>';
echo '<block>';
echo "<prompt>$response</prompt>";
echo "<goto next=\"#f_reiniciar\"/>";
echo '</block>';
echo '</form>';
echo '</vxml>';
?>
