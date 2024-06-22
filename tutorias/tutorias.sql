USE tutorias;

CREATE TABLE estudiantes (
    boleta INT PRIMARY KEY NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    apellido_paterno VARCHAR(50) NOT NULL,
    apellido_materno VARCHAR(50) NOT NULL,
    telefono VARCHAR(10) NOT NULL,
    semestre ENUM('1', '2', '3', '4', '5', '6', '7', '8', '9', '10') NOT NULL,
    carrera VARCHAR(3) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP
);

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tutores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido_paterno VARCHAR(50) NOT NULL,
    apellido_materno VARCHAR(50) NOT NULL,
    genero VARCHAR(1) NOT NULL
);

CREATE TABLE estudianteTutor (
    id_estudiante INT,
    id_tutor INT,
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(boleta),
    FOREIGN KEY (id_tutor) REFERENCES tutores(id),
    PRIMARY KEY (id_estudiante, id_tutor)
);

INSERT INTO administradores (id, email, password_hash, created_at)
VALUES (1, 'admin@ipn.mx', '$2y$10$iDARE96VriTRjI6fgTEtju.uYU66/NVbmx.1YloNbOU1FVvLm1JUe', '2024-05-29 18:31:17');

INSERT INTO tutores (nombre, apellido_paterno, apellido_materno, genero)
VALUES
    ('Juan', 'Pérez', 'López', 'H'),
    ('María', 'Gómez', 'García', 'M'),
    ('Carlos', 'Martínez', 'Hernández', 'H'),
    ('Ana', 'Rodríguez', 'Sánchez', 'M'),
    ('Luis', 'López', 'González', 'H'),
    ('Laura', 'García', 'Ramírez', 'M'),
    ('Pedro', 'Hernández', 'Flores', 'H'),
    ('Sofía', 'Sánchez', 'Torres', 'M');