<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "escom_registro_tutorias";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $boleta = $_POST['boleta'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['AP'];
    $apellido_materno = $_POST['AM'];
    $telefono = $_POST['tel'];
    $semestre = $_POST['semestre'];
    $carrera = $_POST['carrera'];
    $tutor = $_POST['tutor'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $fecha_registro = date("Y-m-d H:i:s");
    $contrasena_hashed = password_hash($contrasena, PASSWORD_BCRYPT);

    // Insertar datos en la base de datos
    $sql = $conn->prepare("INSERT INTO estudiantes (boleta, nombre, apellido_paterno, apellido_materno, telefono, semestre, carrera, genero_tutor, correo, contrasena, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($sql === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $sql->bind_param("sssssssssss", $boleta, $nombre, $apellido_paterno, $apellido_materno, $telefono, $semestre, $carrera, $tutor, $correo, $contrasena_hashed, $fecha_registro);

    if ($sql->execute()) {
        echo "Registro exitoso";
        $sql->close();
        $conn->close();
        header("Location: ../plantillas/mostrar_registro.php");
        exit();
    } else {
        if ($conn->errno == 1062) { // Código de error para clave duplicada en MySQL
            $error_message = "La boleta ya está registrada.";
            header("Location: ../index.html?error=" . urlencode($error_message));
        } else {
            echo "Error: " . $sql->error;
        }
    }

    $sql->close();
    $conn->close();
}
?>
