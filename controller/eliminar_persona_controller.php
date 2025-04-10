<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} else {
    session_destroy();
}

if (!defined('DB_HOST')) {
    require_once 'config.php';
}

if (!isset($conexion)) {
    require_once 'model/conexion.php';
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    try {
        // Sanitizarción del ID
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new Exception("ID inválido");
        }
        $verificar = $conexion->prepare("SELECT id FROM personas WHERE id = ?");
        $verificar->bind_param("i", $id);
        $verificar->execute();
        $verificar->store_result();

        if ($verificar->num_rows == 0) {
            throw new Exception("El registro que intenta eliminar no existe");
        }
        $verificar->close();

        $stmt = $conexion->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();

        if ($resultado) {
            echo $_SESSION['flash_message'] = "<div class='alert alert-success'>Registro eliminado correctamente</div>";
            unset($_SESSION['flash_message']);
        } else {
            throw new Exception("Error al eliminar el registro: " . $conexion->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo $_SESSION['flash_message'] = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        unset($_SESSION['flash_message']);
    }
}
?>