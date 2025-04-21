<?php
require_once __DIR__ . '/../models/conexion.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'ADMIN') {
    header("Location: listar_usuarios_view.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: listar_usuarios_view.php");
    exit;
}

$stmt = $conexion->prepare("SELECT id, nombre, apellidos, rol FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar rol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9af02c82fc.js" crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="sticky-top bg-success text-white">
        <?php include __DIR__ . "/header.php"; ?>
    </header>

    <div class="container mt-5 pt-5" style="background-color:rgb(232, 235, 236); padding: 20px; border-radius: 10px;">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 class="text-center p-1">Rol de <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></h1>
                <form action="../controllers/actualizar_rol_controller.php" method="POST">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <div class="d-flex justify-content-center mb-3">
                        <select name="rol" class="form-select form-select-sm w-auto px-5" style="font-size: 14px;" required>
                            <option value="USER" <?= $usuario['rol'] === 'USER' ? 'selected' : '' ?>>USER</option>
                            <option value="ADMIN" <?= $usuario['rol'] === 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <a href="listar_usuarios_view.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <footer class="mt-auto bg-success text-white py-3">
        <?php include __DIR__ . "/footer.php"; ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>