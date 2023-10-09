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
$serverName = "localhost";
$database = "info_etsiit";
$username = "info_etsiit";
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
        $sql = "SELECT DISTINCT profesor, grupo FROM courses WHERE titulacion = :grado AND asignatura = :asignatura";
        $params = [':grado' => $grado, ':asignatura' => $asignatura];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "\nThe professors of the subject <emphasis>$asignatura</emphasis> in the $grado are:\n";
            $profesorGrupos = [];

            foreach ($results as $row) {
                $profesor = $row['profesor'];
                $grupo = $row['grupo'];
                $tipoDeGrupo = '';

                 // Verificar si el grupo es un número (Laboratory) o una letra (Theory)
                if (is_numeric($grupo)) {
                    $tipoDeGrupo = 'Laboratory group';
                } elseif (ctype_alpha($grupo)) {
                    $tipoDeGrupo = 'Theory group';
                }

                if (!empty($tipoDeGrupo)) {
                    if (!isset($profesorGrupos[$profesor])) {
                        $profesorGrupos[$profesor] = [];
                    }

                    $profesorGrupos[$profesor][] = [
                        'grupo' => $grupo,
                        'tipo' => $tipoDeGrupo,
                    ];
                }
            }

            foreach ($profesorGrupos as $profesor => $grupos) {
                $response .= "\n<break time=\"400ms\"/><emphasis>$profesor</emphasis>; who teaches in ";

                $grupoCount = count($grupos);
                for ($i = 0; $i < $grupoCount; $i++) {
                    $response .= $grupos[$i]['tipo'] . " " . $grupos[$i]['grupo'] . "<break time=\"50ms\"/>";

                    if ($i == $grupoCount - 2) {
                        $response .= " and ";
                    } 
                }
            }
        } else {
            $response = "Sorry, no results found for the $subject in the $grade.";

        }
    } elseif (!empty($grado) && !empty($profesor)) {
        // Titulacion and Profesor -> Asignaturas y Grupos
        $sql = "SELECT DISTINCT asignatura, grupo FROM courses WHERE titulacion = :grado AND profesor = :profesor";
        $params = [':grado' => $grado, ':profesor' => $profesor];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "\nThe subjects taught by the professor <emphasis>$profesor</emphasis> in the $grado are:\n";
            $asignaturaGrupos = [];

            foreach ($results as $row) {
                $asignatura = $row['asignatura'];
                $grupo = $row['grupo'];
                $tipoDeGrupo = '';

                 // Verificar si el grupo es un número (Laboratory) o una letra (Theory)
                if (is_numeric($grupo)) {
                    $tipoDeGrupo = 'Laboratory group';
                } elseif (ctype_alpha($grupo)) {
                    $tipoDeGrupo = 'Theory group';
                }

                if (!isset($asignaturaGrupos[$asignatura])) {
                    $asignaturaGrupos[$asignatura] = [];
                }

                if (!empty($tipoDeGrupo)) {
                    $asignaturaGrupos[$asignatura][] = [
                        'grupo' => $grupo,
                        'tipo' => $tipoDeGrupo,
                    ];
                }
            }

            foreach ($asignaturaGrupos as $asignatura => $grupos) {
                $response .= "\n<break time=\"400ms\"/><emphasis>$asignatura</emphasis>; in ";

                $grupoCount = count($grupos);
                for ($i = 0; $i < $grupoCount; $i++) {
                    $response .= $grupos[$i]['tipo'] . " " . $grupos[$i]['grupo'] . "<break time=\"50ms\"/>";

                    if ($i == $grupoCount - 2) {
                        $response .= " and ";
                    }
                }
            }
        } else {
            $response = "Sorry, no results found for the professor $profesor in the $grado";
        }
    } elseif (!empty($grado) && !empty($asignatura) && !empty($grupo)) {
        // Titulacion, Asignatura, and Grupo -> Horario
        $sql = "SELECT DISTINCT dia_de_la_semana, TIME_FORMAT(hora_inicio, '%H:%i') AS hora_inicio, TIME_FORMAT(hora_fin, '%H:%i') AS hora_fin FROM courses WHERE titulacion = :grado AND asignatura = :asignatura AND grupo = :grupo";
        $params = [':grado' => $grado, ':asignatura' => $asignatura, ':grupo' => $grupo];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "\nThe schedule for the group $grupo of the subject $asignatura in the $grado is:\n";
            foreach ($results as $row) {
                $response .= $row['dia_de_la_semana'] . " from " . $row['hora_inicio'] . " to " . $row['hora_fin'] . "<break time=\"100ms\"/>";
            }
        } else {
            $response = "Sorry, no results found for the group $grupo of the subject $asignatura in the $grado";
        }
    } elseif (!empty($grado) && !empty($curso)) {
        // Titulacion and Curso -> Asignaturas
        $sql = "SELECT DISTINCT asignatura, semestre FROM courses WHERE titulacion = :grado AND curso = :curso";
        $params = [':grado' => $grado, ':curso' => $curso];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "\nThe subjects of the $grado in the <emphasis>$curso</emphasis> are:\n";
            $semestres = [];

            foreach ($results as $row) {
                $asignatura = $row['asignatura'];
                $semestre = $row['semestre'];

                if (!isset($semestres[$semestre])) {
                    $semestres[$semestre] = [];
                }

                $semestres[$semestre][] = [
                    'asignatura' => $asignatura,
                ];
            }

            foreach ($semestres as $semestre => $asignaturas) {
                $response .= "\n<break time=\"400ms\"/><emphasis>$semestre</emphasis>:\n";

                $asignaturasCount = count($asignaturas);
                for ($i = 0; $i < $asignaturasCount; $i++) {
                    $response .= $asignaturas[$i]['asignatura'] . "<break time=\"50ms\"/>";

                if ($i == $asignaturasCount - 2) {
                        $response .= " and ";
                    }
                }
            }
        }else {
            $response = "Sorry, no subjects found for the $grado in the $curso";
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
