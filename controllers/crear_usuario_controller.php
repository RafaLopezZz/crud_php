<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/conexion.php';

// Sólo ADMIN puede crear
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'ADMIN') {
    header('Location: ../views/listar_usuarios_view.php?mensaje=acceso_denegado');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/crear_usuario_view.php');
    exit;
}


$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$dni = trim($_POST['DNI'] ?? '');
$fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';
$confirmar_password = $_POST['confirmar_password'] ?? '';

if (empty($nombre) || empty($apellidos) || empty($dni) || empty($fecha_nacimiento)   || empty($correo)   || empty($password) || empty($confirmar_password)) {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'msg'  => 'Todos los campos son obligatorios'
    ];
    header('Location: ../views/crear_usuario_view.php');
    exit;
}
if ($password !== $confirmar_password) {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'msg'  => 'Las contraseñas no coinciden'
    ];
    header('Location: ../views/crear_usuario_view.php');
    exit;
}

// (Aquí irían tus comprobaciones de email/DNI duplicados, hashing, INSERT...)

// Validar email
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo $_SESSION['flash_message'] = "<div class='alert alert-danger'>El correo electrónico no es válido</div>";
    unset($_SESSION['flash_message']);
    return;
}

// Validar DNI (Ejemplo: 12345678A)
if (!preg_match('/^\d{8}[A-Z]$/', $dni)) {
    echo $_SESSION['flash_message'] =  "<div class='alert alert-danger'>El DNI no tiene un formato válido</div>";
    unset($_SESSION['flash_message']);
    return;
}

// Validar fecha de nacimiento
$fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha_nacimiento) {
    echo $_SESSION['flash_message'] = "<div class='alert alert-danger'>La fecha no tiene un formato válido</div>";
    unset($_SESSION['flash_message']);
    return;
}

try {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conexion->prepare(
        "INSERT INTO usuarios(nombre, apellidos, DNI, fecha_nacimiento, correo, password) VALUES (?,?,?,?,?,?)"
    );
    $stmt->bind_param('ssssss', $nombre, $apellidos, $dni, $fecha_nacimiento, $correo, $hash);
    if (!$stmt->execute()) {
        throw new Exception('No se pudo crear el usuario');
    }
    $stmt->close();

    $_SESSION['flash'] = [
        'type' => 'success',
        'msg'  => 'Usuario creado correctamente'
    ];
    header('Location: ../views/listar_usuarios_view.php');
    exit;
} catch (Exception $ex) {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'msg'  => 'Error: ' . $ex->getMessage()
    ];
    header('Location: ../views/crear_usuario_view.php');
    exit;
}
