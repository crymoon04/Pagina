<?php
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorias";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si los datos del formulario están configurados
if (isset($_POST['correo']) && isset($_POST['correo'])) {
    $adminUsuario = $_POST['correo'];
    $adminContrasena = $_POST['contrasena'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare('SELECT id, password_hash FROM administradores WHERE email = ?');
    if ($stmt) {
        $stmt->bind_param('s', $adminUsuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $passwordHash);
            $stmt->fetch();

            // Verificar la contraseña
            if (password_verify($adminContrasena, $passwordHash)) {
                $_SESSION['admin'] = $adminUsuario;
                header("Location: ../admin/index.html");
                exit();
            } else {
                header("Location: ../admin.html?error=invalid_credentials");
                exit();
            }
        } else {
            // El usuario no existe
            header("Location: ../admin.html?error=user_not_found");
            exit();
        }

        $stmt->close();
    } else {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
} else {
    header("Location: ../admin.html?error=missing_credentials");
    exit();
}

$conn->close();
?>
