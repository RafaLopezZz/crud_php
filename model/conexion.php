<?php
// conexion.php - Crear conexión a la base de datos usando los parámetros de configuración

// Archivo de configuración
// Este archivo contiene las constantes de configuración para la conexión a la base de datos
require_once 'config.php';

// Se crea la conexión
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificación de la conexión
if ($conexion->connect_error) {
    if (DEBUG_MODE) {
        die("Error de conexión: " . $conexion->connect_error);
    } else {
        die("Error de conexión a la base de datos. Por favor, contacte al administrador.");
    }
}

// Establecer el conjunto de caracteres
$conexion->set_charset("utf8mb4");

// Función para cerrar la conexión a la base de datos
function cerrarConexion($conexion) {
    if ($conexion) {
        $conexion->close();
    }
}
?>