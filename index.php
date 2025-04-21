<?php
require_once __DIR__ . '/models/config.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    require_once __DIR__ . '/controllers/logout_controller.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RafaLopezZz's CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
<header class="sticky-top bg-success text-white">
        <?php include "views/header.php"; ?>
    </header>
    <div class="container mt-5 pb-5" style="background-color:rgb(232, 235, 236); padding: 20px; border-radius: 10px;">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1>Bienvenido al CRUD de RafaLopezZz</h1>
                <div class="mt-4">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>views/listar_usuarios_view.php" class="btn btn-primary btn-lg mx-2">Listar usuarios</a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>views/login_view.php" class="btn btn-primary btn-lg mx-2">Iniciar Sesión</a>
                        <a href="<?php echo BASE_URL; ?>views/registro_view.php" class="btn btn-success btn-lg mx-2">Registrarse</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-auto bg-success text-white py-3">
        <?php
        include "views/footer.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>