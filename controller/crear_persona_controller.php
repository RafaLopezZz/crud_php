<?php
// Se inicia la sesión para manejar variables de sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificación de ficheros de configuración y conexión
// Se verifica si el archivo de configuración y conexión existen y se incluyen
if (!defined('DB_HOST')) {
    require_once 'config.php';
}

if (!isset($conexion)) {
    require_once 'model/conexion.php';
}

if(!empty($_POST['btnregistrar'])){
    if(!empty($_POST["nombre"]) && !empty($_POST["apellidos"]) && !empty($_POST["DNI"]) && !empty($_POST["fecha_nacimiento"]) && !empty($_POST["correo"])) {
        
        // Sanitizar datos

        $nombre = htmlspecialchars(trim($_POST["nombre"]));
        $apellidos = htmlspecialchars(trim($_POST["apellidos"]));
        $dni = htmlspecialchars(trim($_POST["DNI"]));
        $fecha_nacimiento = htmlspecialchars(trim($_POST["fecha_nacimiento"]));
        $correo = htmlspecialchars(trim($_POST["correo"]));
        
        // Validar email
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_message'] = "<div class='alert alert-danger'>El correo electrónico no es válido</div>";
            echo $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return;
        }
        
        // Validar DNI (Ejemplo: 12345678A)
        if (!preg_match('/^\d{8}[A-Z]$/', $dni)) {
            $_SESSION['flash_message'] = "<div class='alert alert-danger'>El DNI no tiene un formato válido</div>";
            echo $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return;
        }

        // Validar fecha de nacimiento
        $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
        if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha_nacimiento) {
            $_SESSION['flash_message'] = "<div class='alert alert-danger'>La fecha no tiene un formato válido</div>";
            echo $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return;
        }

        try {
            // Consulta preparada - PreparedStatement
            $stmt = $conexion->prepare("INSERT INTO personas (nombre, apellidos, DNI, fecha_nacimiento, correo) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nombre, $apellidos, $dni, $fecha_nacimiento, $correo);
            $resultado = $stmt->execute();
            
            if($resultado) {
                $_SESSION['flash_message'] = "<div class='alert alert-success'>Registro exitoso</div>";
                echo $_SESSION['flash_message'];
                unset($_SESSION['flash_message']);
            } else {
                throw new Exception("Error al insertar los datos");
            }
            
            // Cerrar el statement
            $stmt->close();
            
        } catch (Exception $ex) {
            if(DEBUG_MODE) {
                $_SESSION['flash_message'] = "<div class='alert alert-danger'>Error: " . $ex->getMessage() . "</div>";
                echo $_SESSION['flash_message'];
                unset($_SESSION['flash_message']);
            } else {
                $_SESSION['flash_message'] = "<div class='alert alert-danger'>Error al procesar la solicitud.</div>";
                echo $_SESSION['flash_message'];
                unset($_SESSION['flash_message']);
                error_log("Error en crear_persona_controller: " . $ex->getMessage());
            }
            $_SESSION['flash_message'] = "<div class='alert alert-danger'>Error: " . $ex->getMessage() . "</div>";
            echo $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
    } else {
        $_SESSION['flash_message'] = "<div class='alert alert-warning'>Todos los campos son obligatorios</div>";
        echo $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
    }
}
?>