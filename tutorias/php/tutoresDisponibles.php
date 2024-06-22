<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorias";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $error = array("error" => "Error de conexión: " . $conn->connect_error);
    header('Content-Type: application/json');
    echo json_encode($error);
    exit; // Detener la ejecución si hay un error de conexión
}

// Obtener el género del formulario (¡sanitizar en una aplicación real!)
$genero = $_POST['genero'];

// Consulta SQL preparada y segura
$sql = "SELECT t.id, t.nombre, t.apellido_paterno, t.apellido_materno
        FROM tutores t
        INNER JOIN estudianteTutor et ON t.id = et.id_tutor
        WHERE t.genero = M
        GROUP BY t.id
        HAVING COUNT(et.id_estudiante) <= 15";

$stmt = $conn->prepare($sql);
//$stmt->bind_param("s", $genero);
$stmt->execute();
$result = $stmt->get_result();

// Manejo de errores de la consulta
if (!$result) {
    $error = array("error" => "Error en la consulta: " . $conn->error);
    header('Content-Type: application/json');
    echo json_encode($error);
    exit; // Detener la ejecución si hay un error en la consulta
}

// Construir el arreglo de tutores
$tutores = array();
while ($row = $result->fetch_assoc()) {
    $tutores[] = $row;
}

// Enviar respuesta JSON (sin mensajes de depuración)
echo json_encode($tutores);

// Cerrar recursos
$stmt->close();
$conn->close();
?>
