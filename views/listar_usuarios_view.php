<?php
require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['rol'])) {
  $_SESSION['rol'] = 'USER';
}

if (!isset($_SESSION["usuario_id"])) {
  header("location: login_view.php?mensaje=acceso_denegado");
  exit;
}
?>

<script>
  function eliminar() {
    return confirm("¿Está seguro de que quiere eliminar el registro?");
  }
</script>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD en PHP y MySQL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/9af02c82fc.js" crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column min-vh-100">

  <header class="fixed-top bg-success text-white">
    <?php include __DIR__ . "/header.php"; ?>
  </header>

  <div class="container mt-5 pt-5">
    <h1 class="text-center p-3">Listar usuarios</h1>
    <?php if (isset($_SESSION['flash_message'])): ?>
      <?php
      list($tipo, $mensaje) = explode(':', $_SESSION['flash_message'], 2);
      unset($_SESSION['flash_message']);
      ?>
      <div class="alert alert-<?= htmlspecialchars($tipo) ?> alert-dismissible fade show text-center" role="alert">
        <?= htmlspecialchars($mensaje) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    <?php endif; ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-success">
          <tr>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'USER'): ?>
              <th>#</th>
            <?php endif; ?>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'ADMIN'): ?>
              <th>Fecha de nacimiento</th>
              <th>DNI</th>
              <th>Rol</th>
              <th>Acciones</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($_SESSION['rol'] === 'ADMIN') {
            $sql = "SELECT id, nombre, apellidos, dni, correo, fecha_nacimiento, rol FROM usuarios";
          } else {
            $sql = "SELECT id, nombre, apellidos, correo FROM usuarios";
          }

          $stmt = $conexion->prepare($sql);
          $stmt->execute();
          $result   = $stmt->get_result();
          $usuarios = $result->fetch_all(MYSQLI_ASSOC);

          foreach ($usuarios as $usuario):
          ?>
            <tr>
              <?php if ($_SESSION['rol'] === 'USER'): ?>
                <td><?= htmlspecialchars($usuario['id']) ?></td>
              <?php endif; ?>

              <td><?= htmlspecialchars($usuario['nombre']) ?></td>
              <td><?= htmlspecialchars($usuario['apellidos']) ?></td>
              <td><?= htmlspecialchars($usuario['correo']) ?></td>

              <?php if ($_SESSION['rol'] === 'ADMIN'): ?>
                <td><?= htmlspecialchars($usuario['fecha_nacimiento']) ?></td>
                <td><?= htmlspecialchars($usuario['dni']) ?></td>
                <td><?= htmlspecialchars($usuario['rol']) ?></td>
                <td>
                  <a href="actualizar_usuario_view.php?id=<?= htmlspecialchars($usuario['id']) ?>" class="btn btn-sm btn-warning">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <a href="../controllers/eliminar_usuario_controller.php?id=<?= htmlspecialchars($usuario['id']) ?>" onclick="return eliminar()" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                  <a href="editar_rol_view.php?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-info">
                    <i class="fa-solid fa-user-gear"></i>
                  </a>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer class="mt-auto bg-success text-white py-3">
    <?php include __DIR__ . "/footer.php"; ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  // Esperar a que el DOM esté listo
  document.addEventListener("DOMContentLoaded", function () {
    const alert = document.querySelector(".alert");
    if (alert) {
      // Espera 4 segundos y luego oculta la alerta suavemente
      setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close(); // Usa la clase de Bootstrap para cerrarla correctamente
      }, 4000);
    }
  });
</script>
</body>

</html>