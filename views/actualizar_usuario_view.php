<?php
require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/conexion.php';
$id = $_GET['id'];
$sql = $conexion->query("SELECT * FROM usuarios WHERE id='$id'");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ACTUALIZAR USUARIO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="fixed-top bg-success text-white">
        <?php include __DIR__ . "/header.php"; ?>
    </header>

    <form class="col-4 p-3 m-auto" method="POST" action="">
        <h3 class="text-center text-secondary">Modificar usuario</h3>
        <?php
        include __DIR__ . '/../controllers/actualizar_usuario_controller.php';
        while ($datos = $sql->fetch_object()) { ?>

            <div class="mb-3">
                <label for="inputNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $datos->nombre; ?>">
            </div>
            <div class="mb-3">
                <label for="inputAoellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" value="<?php echo $datos->apellidos; ?>">
            </div>
            <div class="mb-3">
                <label for="inputDNI" class="form-label">DNI</label>
                <input type="text" class="form-control" name="dni" value="<?php echo $datos->dni; ?>">
            </div>
            <div class="mb-3">
                <label for="inputFecha" class="form-label">Fecha de nacimiento</label>
                <input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo $datos->fecha_nacimiento; ?>">
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Correo</label>
                <input type="email" class="form-control" name="correo" value="<?php echo $datos->correo; ?>">
            </div>
        <?php }

        ?>
        <button type="submit" class="btn btn-primary" name="btnactualizar" value="ok">Actualizar usuario</button>
    </form>

    <footer class="mt-auto bg-success text-white py-3">
        <?php include __DIR__ . "/footer.php"; ?>
    </footer>

</body>

</html>