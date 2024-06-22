<?php
echo("0");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escom_registro_tutorias";
echo("a");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo("b");
$genero = $_POST['genero'];
echo("c");

$sql = "SELECT t.id, t.nombre, t.apellido_paterno, t.apellido_materno
        FROM tutores t
        LEFT JOIN estudianteTutor et ON t.id = et.id_tutor
        WHERE t.genero = '$genero'
        GROUP BY t.id
        HAVING COUNT(et.id_estudiante) <= 15";
echo("d");

$result = $conn->query($sql);
echo("e");

$tutores = array();
echo("f");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tutores[] = $row; 
    }
}
echo("g");


header('Content-Type: application/json');
echo json_encode($tutores);
echo("f");

$conn->close();
?>
