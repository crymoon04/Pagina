USE escom_registro_tutorias;

CREATE TABLE estudiantes (
    boleta VARCHAR(10) PRIMARY KEY NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    apellido_paterno VARCHAR(50) NOT NULL,
    apellido_materno VARCHAR(50) NOT NULL,
    telefono VARCHAR(10) NOT NULL,
    semestre VARCHAR(10) NOT NULL, 
    carrera VARCHAR(30) NOT NULL,
    genero_tutor VARCHAR(30) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP
);

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar un administrador con los datos especificados
INSERT INTO administradores (id, username, password_hash, email, created_at)
VALUES (1, 'admin', '$2y$10$iDARE96VriTRjI6fgTEtju.uYU66/NVbmx.1YloNbOU1FVvLm1JUe', 'admin@ipn.mx', '2024-05-29 18:31:17');
--contraseña es admin123
--usuario admin