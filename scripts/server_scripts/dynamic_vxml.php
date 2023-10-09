/**
 * 
 * This script handles a VoiceXML POST request and returns a response based on the input parameters in spanish.
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
$serverName = "localhost";
$database = "info_etsiit";
$username = "info_etsiit";
$password = "Akie4puyXm";

// Initialize the response
$response = "";
$goodbye = "Gracias por usar el servicio. Adios.";

// Connected to the database
$connected = true;

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
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
        // Titulacion and Asignatura -> Profesor y Grupos (Teoría o Prácticas)
        $sql = "SELECT DISTINCT profesor, grupo FROM cursos WHERE titulacion = :grado AND asignatura = :asignatura";
        $params = [':grado' => $grado, ':asignatura' => $asignatura];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "\nLos profesores de la asignatura <emphasis>$asignatura</emphasis> en el $grado son:\n";
            $profesorGrupos = [];

            foreach ($results as $row) {
                $profesor = $row['profesor'];
                $grupo = $row['grupo'];
                $tipoDeGrupo = '';

                // Verificar si el grupo es un número (Laboratory) o una letra (Theory)
                if (is_numeric($grupo)) {
                    $tipoDeGrupo = 'Grupo de practicas';
                } elseif (ctype_alpha($grupo)) {
                    $tipoDeGrupo = 'Grupo de teoria';
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
                $response .= "\n<break time=\"400ms\"/><emphasis>$profesor</emphasis>; que imparte en el ";

                $grupoCount = count($grupos);
                for ($i = 0; $i < $grupoCount; $i++) {
                    $response .= $grupos[$i]['tipo'] . " " . $grupos[$i]['grupo'] . "<break time=\"50ms\"/>";

                    if ($i == $grupoCount - 2) {
                        $response .= " y ";
                    } 
                }
            }
        } else {
            $response = "Lo siento, no se encontraron resultados para la $asignatura del $grado.";
        }
    } elseif (!empty($grado) && !empty($profesor)) {
        // Titulacion and Profesor -> Asignaturas y Grupos
        $sql = "SELECT DISTINCT asignatura, grupo FROM cursos WHERE titulacion = :grado AND profesor = :profesor";
        $params = [':grado' => $grado, ':profesor' => $profesor];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "\nLas asignaturas que imparte el profesor <emphasis>$profesor</emphasis> en el $grado son:\n";
            $asignaturaGrupos = [];

            foreach ($results as $row) {
                $asignatura = $row['asignatura'];
                $grupo = $row['grupo'];
                $tipoDeGrupo = '';

                // Verificar si el grupo es un número (Laboratory) o una letra (Theory)
                if (is_numeric($grupo)) {
                    $tipoDeGrupo = 'Grupo de practicas';
                } elseif (ctype_alpha($grupo)) {
                    $tipoDeGrupo = 'Grupo de teoria';
                }

                if (!empty($tipoDeGrupo)) {
                    if (!isset($asignaturaGrupos[$asignatura])) {
                        $asignaturaGrupos[$asignatura] = [];
                    }

                    $asignaturaGrupos[$asignatura][] = [
                        'grupo' => $grupo,
                        'tipo' => $tipoDeGrupo,
                    ];
                }
            }

            foreach ($asignaturaGrupos as $asignatura => $grupos) {
                $response .= "\n<break time=\"400ms\"/><emphasis>$asignatura</emphasis>; en el ";

                $grupoCount = count($grupos);
                for ($i = 0; $i < $grupoCount; $i++) {
                    $response .= $grupos[$i]['tipo'] . " " . $grupos[$i]['grupo'] . "<break time=\"50ms\"/>";

                    if ($i == $grupoCount - 2) {
                        $response .= " y ";
                    }
                }
            }
        } else {
            $response = "Lo siento, no se encontraron resultados para el profesor $profesor en el $grado";
        }
    } elseif (!empty($grado) && !empty($asignatura) && !empty($grupo)) {
        // Titulacion, Asignatura, and Grupo -> Horario
        $sql = "SELECT DISTINCT dia_de_la_semana, TIME_FORMAT(hora_inicio, '%H:%i') AS hora_inicio, TIME_FORMAT(hora_fin, '%H:%i') AS hora_fin FROM cursos WHERE titulacion = :grado AND asignatura = :asignatura AND grupo = :grupo";
        $params = [':grado' => $grado, ':asignatura' => $asignatura, ':grupo' => $grupo];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "\nEl horario para el grupo $grupo de la asignatura $asignatura en el $grado es:\n";
            foreach ($results as $row) {
                $response .= $row['dia_de_la_semana'] . " de " . $row['hora_inicio'] . " a " . $row['hora_fin'] . "<break time=\"100ms\"/>";
            }
        } else {
            $response = "Lo siento, no se encontraron resultados para el grupo $grupo de la asignatura $asignatura en el $grado";
        }
    } elseif (!empty($grado) && !empty($curso)) {
        // Titulacion and Curso -> Asignaturas por Semestre
        $sql = "SELECT DISTINCT asignatura, semestre FROM cursos WHERE titulacion = :grado AND curso = :curso";
        $params = [':grado' => $grado, ':curso' => $curso];
        $results = executeQuery($conn, $sql, $params);

        if (count($results) > 0) {
            $response = "\nLas asignaturas del $grado en el <emphasis>$curso</emphasis> son:\n";
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
                        $response .= " y ";
                    }
                }
            }
        }else {
            $response = "Lo siento, no se encontraron asignaturas para el $grado en el $curso";
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
echo "<prompt>$goodbye</prompt>";
echo '<exit/>';
echo '</block>';
echo '</form>';
echo '</vxml>';
?>
