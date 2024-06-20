<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escom_registro_tutorias";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$genero = $_POST['genero'];

$sql = "SELECT t.id, t.nombre, t.apellido_paterno, t.apellido_materno
        FROM tutores t
        LEFT JOIN estudianteTutor et ON t.id = et.id_tutor
        WHERE t.genero = '$genero'
        GROUP BY t.id
        HAVING COUNT(et.id_estudiante) <= 15";

$result = $conn->query($sql);

$tutores = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tutores[] = $row; 
    }
}

header('Content-Type: application/json');
echo json_encode($tutores);

$conn->close();
?>
