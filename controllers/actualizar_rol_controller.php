<?php
require_once __DIR__ . '/../models/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'ADMIN') {
        header("Location: ../views/login_view.php");
        exit;
    }

    $id  = $_POST['id'];
    $rol = $_POST['rol'];

    if (!in_array($rol, ['ADMIN', 'USER'])) {
        die("Rol inválido.");
    }

    $stmt = $conexion->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
    $stmt->bind_param("si", $rol, $id);

    if ($stmt->execute()) {
        header("Location: ../views/listar_usuarios_view.php?mensaje=rol_actualizado");
    } else {
        echo "Error al actualizar el rol.";
    }
}
?>