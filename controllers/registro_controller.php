<?php
(session_status() === PHP_SESSION_NONE) ? session_start() : session_destroy();

if (!defined('DB_HOST')) {
    require_once __DIR__ . '/../models/config.php';
}
if (!isset($conexion)) {
    require_once __DIR__ . '/../models/conexion.php';
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/registro_view.php');
    exit;
}

$nombre = htmlspecialchars(trim($_POST["nombre"]));
$apellidos = htmlspecialchars(trim($_POST["apellidos"]));
$dni = htmlspecialchars(trim($_POST["DNI"]));
$fecha_nacimiento = htmlspecialchars(trim($_POST["fecha_nacimiento"]));
$correo = htmlspecialchars(trim($_POST["correo"]));
$password          = $_POST['password'] ?? '';
$confirmar_password= $_POST['confirmar_password'] ?? '';

if(!empty($_POST["nombre"]) && !empty($_POST["apellidos"]) && !empty($_POST["DNI"]) && !empty($_POST["fecha_nacimiento"]) && !empty($_POST["correo"])) {
    $_SESSION['error'] = 'Todos los campos son obligatorios';
    header('Location: ../views/registro_view.php');
    exit;
}
if ($password !== $confirmar_password) {
    $_SESSION['error'] = 'Las contraseñas no coinciden';
    header('Location: ../views/registro_view.php');
    exit;
}

try {
    // Verificación si el correo ya existe
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = ?");
    if (!$stmt) {
        throw new Exception('Error interno (verificación de correo)');
    }
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $stmt->bind_result($countCorreo);
    $stmt->fetch();
    $stmt->close();
    if ($countCorreo > 0) {
        throw new Exception('El correo electrónico ya está registrado');
    }

    // Verificación si el DNI ya existe
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE dni = ?");
    if (!$stmt) {
        throw new Exception('Error interno (verificación de DNI)');
    }
    $stmt->bind_param('s', $dni);
    $stmt->execute();
    $stmt->bind_result($countDni);
    $stmt->fetch();
    $stmt->close();
    if ($countDni > 0) {
        throw new Exception('El DNI ya está registrado');
    }

    // Hasheo de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Inserción del nuevo usuario
    $stmt = $conexion->prepare(
        "INSERT INTO usuarios (nombre, apellidos, dni, fecha_nacimiento, correo, password)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    if (!$stmt) {
        throw new Exception('Error interno (inserción de usuario)');
    }
    $stmt->bind_param('ssssss', $nombre, $apellidos, $dni, $fecha_nacimiento, $correo, $password_hash);
    if (!$stmt->execute()) {
        throw new Exception('Error al registrar el usuario');
    }
    $newUserId = $conexion->insert_id;
    $stmt->close();

    // Auto-login
    $_SESSION['usuario_id'] = $newUserId;
    $_SESSION['nombre']     = $nombre;
    $_SESSION['apellidos']  = $apellidos;
    $_SESSION['correo']     = $correo;

    // Redirección al listado de usuarios (protegido)
    header('Location: ../views/listar_usuarios_view.php');
    exit;

} catch (Exception $ex) {
    // Capturar cualquier excepción y volver al formulario
    $_SESSION['error'] = $ex->getMessage();
    header('Location: ../views/registro_view.php');
    exit;
}
?>