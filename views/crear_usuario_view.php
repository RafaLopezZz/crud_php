<?php
require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/conexion.php';

// Obtener el ID desde la URL
$id = $_GET['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: listar_usuarios_view.php");
    exit;
}

// Obtener los datos del usuario desde la base de datos
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Actualizar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body class="d-flex flex-column min-vh-100">

    <header class="fixed-top bg-success text-white">
        <?php include __DIR__ . "/header.php"; ?>
    </header>

    <main class="flex-grow-1 pt-5 mt-5">
        <form class="col-4 p-3 m-auto" method="POST" action="../controllers/actualizar_usuario_controller.php">
            <h3 class="text-center text-secondary">Actualizar usuario</h3>

            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

            <div class="mb-3">
                <label for="inputNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="inputApellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="inputDNI" class="form-label">DNI</label>
                <input type="text" class="form-control" name="dni" value="<?php echo htmlspecialchars($usuario['dni']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="inputFecha" class="form-label">Fecha de nacimiento</label>
                <input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo $usuario['fecha_nacimiento']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="inputEmail" class="form-label">Correo</label>
                <input type="email" class="form-control" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="btnactualizar" value="ok">Actualizar usuario</button>
        </form>
    </main>

    <footer class="mt-auto bg-success text-white py-3">
        <?php include __DIR__ . "/footer.php"; ?>
    </footer>

</body>
</html>
