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

if (!empty($_POST['btnactualizar'])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["apellidos"]) && !empty($_POST["DNI"]) && !empty($_POST["fecha_nacimiento"]) && !empty($_POST["correo"])) {

        $nombre = htmlspecialchars(trim($_POST["nombre"]));
        $apellidos = htmlspecialchars(trim($_POST["apellidos"]));
        $dni = htmlspecialchars(trim($_POST["DNI"]));
        $fecha_nacimiento = htmlspecialchars(trim($_POST["fecha_nacimiento"]));
        $correo = htmlspecialchars(trim($_POST["correo"]));
    }

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
        // Consulta preparada - PreparedStatement
        $stmt = $conexion->prepare("UPDATE personas SET nombre=?, apellidos=?, DNI=?, fecha_nacimiento=?, correo=? WHERE id=?");
        $stmt->bind_param("sssssi", $nombre, $apellidos, $dni, $fecha_nacimiento, $correo, $id);
        $resultado = $stmt->execute();

        if ($resultado) {
            echo $_SESSION['flash_message'] = "<div class='alert alert-success'>Datos actualizados con éxito</div>";
            unset($_SESSION['flash_message']);
            // Redirige a la página principal después de la actualización
            header("location: index.php?mensaje=modificado");
        } else {
            throw new Exception("Error al insertar los datos");
        }

        // Cerrar el statement
        $stmt->close();
    } catch (Exception $ex) {
        if (DEBUG_MODE) {
            echo $_SESSION['flash_message'] = "<div class='alert alert-danger'>Error: " . $ex->getMessage() . "</div>";
            unset($_SESSION['flash_message']);
        } else {
            echo $_SESSION['flash_message'] = "<div class='alert alert-danger'>Error al procesar la solicitud.</div>";
            unset($_SESSION['flash_message']);
            error_log("Error en crear_persona_controller: " . $ex->getMessage());
        }
        echo $_SESSION['flash_message'] = "<div class='alert alert-danger'>Error: " . $ex->getMessage() . "</div>";
        unset($_SESSION['flash_message']);
    }
}

?>