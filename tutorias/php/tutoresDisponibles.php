<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escom_registro_tutorias";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el género del formulario (¡sanitizar en una aplicación real!)
$genero = $_POST['genero'];
echo "Género recibido en PHP: " . $genero; // Depuración: Mostrar el género recibido

// Consulta SQL preparada y segura
$sql = "SELECT t.id, t.nombre, t.apellido_paterno, t.apellido_materno
        FROM tutores t
        INNER JOIN estudianteTutor et ON t.id = et.id_tutor
        WHERE t.genero = ?
        GROUP BY t.id
        HAVING COUNT(et.id_estudiante) <= 15";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $genero);
$stmt->execute();
$result = $stmt->get_result();

// Manejo de errores de la consulta
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Construir el arreglo de tutores
$tutores = array();
while ($row = $result->fetch_assoc()) {
    $tutores[] = $row;
}

echo "Número de tutores encontrados: " . count($tutores); // Depuración: Mostrar cuántos tutores se encontraron

// Enviar respuesta JSON
header('Content-Type: application/json');
echo json_encode($tutores);

// Cerrar recursos
$stmt->close();
$conn->close();
?>
