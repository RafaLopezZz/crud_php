<?php
(session_status() === PHP_SESSION_NONE) ? session_start() : session_destroy();

if (!defined('DB_HOST')) {
    require_once '../models/config.php';
}

if (!isset($conexion)) {
    require_once '../models/conexion.php';
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../views/login_view.php?mensaje=acceso_denegado');
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    try {
        // Sanitización del ID
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new Exception("ID inválido");
        }

        $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE id = ?");
        $verificar->bind_param("i", $id);
        $verificar->execute();
        $verificar->store_result();

        if ($verificar->num_rows == 0) {
            throw new Exception("El usuario no existe");
        }
        $verificar->close();

        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();

        if ($resultado) {
            $_SESSION['flash_message'] = "success:Registro eliminado correctamente.";
        } else {
            throw new Exception("Error al eliminar el registro.");
        }

        $stmt->close();
    } catch (Exception $ex) {
        $_SESSION['flash_message'] = "danger:Error: " . $ex->getMessage();
    }

    header("Location: ../views/listar_usuarios_view.php");
    exit;
}
