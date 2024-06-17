<?php
require 'funcionesBD.php';

session_start();

if (!isset($_SESSION['admin'])) {
    http_response_code(401); // No autorizado
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

function validateAndSanitize($data) {
    $validatedData = [];

    // Validar y sanitizar boleta
    if (isset($data['boleta']) && preg_match('/^\d{10}$/', $data['boleta'])) {
        $validatedData['boleta'] = $data['boleta'];
    } else {
        return ['status' => 'error', 'message' => 'Boleta inválida'];
    }

    // Validar y sanitizar nombre
    if (isset($data['nombre']) && preg_match('/^[a-zA-Z\s]+$/', $data['nombre'])) {
        $validatedData['nombre'] = filter_var($data['nombre'], FILTER_SANITIZE_STRING);
    } else {
        return ['status' => 'error', 'message' => 'Nombre inválido'];
    }

    // Validar y sanitizar apellido paterno
    if (isset($data['AP']) && preg_match('/^[a-zA-Z\s]+$/', $data['AP'])) {
        $validatedData['AP'] = filter_var($data['AP'], FILTER_SANITIZE_STRING);
    } else {
        return ['status' => 'error', 'message' => 'Apellido paterno inválido'];
    }

    // Validar y sanitizar apellido materno
    if (isset($data['AM']) && preg_match('/^[a-zA-Z\s]+$/', $data['AM'])) {
        $validatedData['AM'] = filter_var($data['AM'], FILTER_SANITIZE_STRING);
    } else {
        return ['status' => 'error', 'message' => 'Apellido materno inválido'];
    }

    // Validar y sanitizar teléfono
    if (isset($data['tel']) && preg_match('/^\d{10}$/', $data['tel'])) {
        $validatedData['tel'] = $data['tel'];
    } else {
        return ['status' => 'error', 'message' => 'Teléfono inválido'];
    }

    // Validar y sanitizar semestre
    if (isset($data['semestre']) && filter_var($data['semestre'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 10]])) {
        $validatedData['semestre'] = $data['semestre'];
    } else {
        return ['status' => 'error', 'message' => 'Semestre inválido'];
    }

    // Validar y sanitizar carrera
    $validCarreras = ['ISC', 'LCD', 'IA'];
    if (isset($data['carrera']) && in_array($data['carrera'], $validCarreras)) {
        $validatedData['carrera'] = $data['carrera'];
    } else {
        return ['status' => 'error', 'message' => 'Carrera inválida'];
    }

    // Validar y sanitizar tutor
    $validTutores = ['H', 'M'];
    if (isset($data['tutor']) && in_array($data['tutor'], $validTutores)) {
        $validatedData['tutor'] = $data['tutor'];
    } else {
        return ['status' => 'error', 'message' => 'Tutor inválido'];
    }

    // Validar y sanitizar correo
    if (isset($data['correo']) && filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
        $validatedData['correo'] = filter_var($data['correo'], FILTER_SANITIZE_EMAIL);
    } else {
        return ['status' => 'error', 'message' => 'Correo inválido'];
    }

    // Validar y sanitizar contraseña (sin validación específica, solo sanitización básica)
    if (isset($data['contrasena'])) {
        $validatedData['contrasena'] = $data['contrasena'];
    } else {
        return ['status' => 'error', 'message' => 'Contraseña requerida'];
    }

    return ['status' => 'success', 'data' => $validatedData];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operacion = $_POST['operacion'] ?? '';

    // Validar y sanitizar los datos
    $validationResult = validateAndSanitize($_POST);
    if ($validationResult['status'] === 'error') {
        echo json_encode($validationResult);
        exit;
    }
    $sanitizedData = $validationResult['data'];

    // Llamar a la función correspondiente con los datos validados y sanitizados
    switch ($operacion) {
        case 'load':
            $response = load();
            break;
        case 'create':
            $response = create($sanitizedData);
            break;
        case 'read':
            $response = read($sanitizedData);
            break;
        case 'update':
            $response = update($sanitizedData);
            break;
        case 'delete':
            $response = delete($sanitizedData);
            break;
        default:
            $response = ['status' => 'error', 'message' => 'Operación no válida'];
    }

    echo json_encode($response);
}
?>
