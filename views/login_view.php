<?php
(session_status() === PHP_SESSION_NONE) ? session_start() : session_destroy();

if (!defined('DB_HOST')) {
    require_once '../models/config.php';
}

if (!isset($conexion)) {
    require_once '../models/conexion.php';
}

if (isset($_SESSION["usuario_id"])) {
    header("location: listar_usuarios_view.php?mensaje=ya_registrado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9af02c82fc.js" crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="sticky-top bg-success text-white">
        <?php include __DIR__ . "/header.php"; ?>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Iniciar Sesión</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['error'];
                                unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="../controllers/login_controller.php" method="POST">
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>¿No tienes cuenta? <a href="registro_view.php">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto bg-success text-white py-3">
        <?php include __DIR__ . "/footer.php"; ?>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>