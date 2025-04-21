<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//(session_status() === PHP_SESSION_NONE) ? session_start() : session_destroy();

if (!defined('DB_HOST')) {
    require_once __DIR__ . '/../models/config.php';
}

if (!isset($conexion)) {
    require_once __DIR__ . '/../models/conexion.php';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/login_view.php');
    exit;
}
$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';

if (empty($correo) || empty($password)) {
    $_SESSION['error'] = 'Introduce tu correo y contraseña';
    header('Location: ../views/login_view.php');
    exit;
}

try {

    $stmt = $conexion->prepare("SELECT id, nombre, apellidos, correo, password, rol FROM usuarios WHERE correo = ?");
    if (!$stmt) {
        // Error en la preparación
        $_SESSION['error'] = 'Error interno. Inténtalo más tarde.';
        header('Location: ../views/login_view.php');
        exit;
    }
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    // Verificación que existe el usuario
    if ($stmt->num_rows === 1) {
        // Asociar resultados a variables
        $stmt->bind_result($id, $nombre, $apellidos, $correo_db, $password_hash, $rol_db);
        $stmt->fetch();

        // Verificación de la contraseña
        if (password_verify($password, $password_hash)) {
            // Login exitoso: Se crean variables de sesión
            $_SESSION['usuario_id'] = $id;
            $_SESSION['nombre']     = $nombre;
            $_SESSION['apellidos']  = $apellidos;
            $_SESSION['correo']     = $correo_db;
            $_SESSION['rol']        = $rol_db;

            $_SESSION['success']    = 'Bienvenido ' . $nombre . ' ' . $apellidos;
            header('Location: ../views/listar_usuarios_view.php');
            exit;
        }
    }
    $_SESSION['error'] = 'Correo o contraseña incorrectos';
    header('Location: ../views/login_view.php');
    exit;
} catch (Exception $ex) {
    $_SESSION['error'] = 'Error al iniciar sesión: ' . $ex->getMessage();
    header('Location: ../views/login_view.php');
    exit;
} finally {
    $stmt->close();
    $conexion->close();
}
