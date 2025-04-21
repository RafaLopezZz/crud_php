<?php
(session_status() === PHP_SESSION_NONE) ? session_start() : session_destroy();

if (!defined('DB_HOST')) {
    require_once '../models/config.php';
}

if (!isset($conexion)) {
    require_once '../models/conexion.php';
}

if (isset($_SESSION["usuario_id"])) {
    header("location: listar_usuarios_view.php?mensaje=usuario_actualizado");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9af02c82fc.js" crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="fixed-top bg-success text-white">
        <?php include __DIR__ . "/header.php"; ?>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Registro de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['error'];
                                unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form class="needs-validation" novalidate action="../controllers/registro_controller.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombreFeedback" required>
                                <div id="nombreFeedback" class="invalid-feedback">
                                    Introduzca su nombre
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" aria-describedby="apellidosFeedback" required>
                                <div id="apellidosFeedback" class="invalid-feedback">
                                    Introduzca sus apellidos
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="DNI" name="DNI" aria-describedby="dniFeedback" required>
                                <div id="dniFeedback" class="invalid-feedback">
                                    Introduzca un DNI válido
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" aria-describedby="fecha_nacimientoFeedback" required>
                                <div id="fecha_nacimientoFeedback" class="invalid-feedback">
                                    Introduzca una fecha válida
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" aria-describedby="correoFeedback" required>
                                <div id="correoFeedback" class="invalid-feedback">
                                    Introduzca un correo electrónico válido
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordFeedback" required>
                                <div id="passwordFeedback" class="invalid-feedback">
                                    Introduzca una contraseña válida
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" aria-describedby="confirmar_passwordFeedback" required>
                                <div id="confirmar_passwordFeedback" class="invalid-feedback">
                                    Confirme su contraseña
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Registrarse</button>
                            </div>
                        </form>
                        <script>
                            // JS para activar validación de Bootstrap
                            (() => {
                                'use strict';
                                const forms = document.querySelectorAll('.needs-validation');
                                Array.from(forms).forEach(form => {
                                    form.addEventListener('submit', event => {
                                        if (!form.checkValidity()) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                        form.classList.add('was-validated');
                                    }, false);
                                });
                            })();
                        </script>
                    </div>
                    <div class="card-footer text-center">
                        <p>¿Ya tienes cuenta? <a href="login_view.php">Inicia sesión aquí</a></p>
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