<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD en PHP y MySQL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/9af02c82fc.js" crossorigin="anonymous"></script>
</head>

<body>
  <script>
    function eliminar() {
      var confirmacion=confirm("¿Está seguro de que quiere eliminar el registro?");
      return confirmacion;
    }
  </script>  
  <h1 class="text-center p-3">CRUD en PHP y MySQL</h1>
  <h2 class="text-center">Crear, Leer, Actualizar y Borrar</h2>

  <?php
    include "model/conexion.php";
    include "controller/eliminar_persona_controller.php";
  ?>

  <div class="container-fluid row">
    <form class="col-4 p-3" method="POST" action="">
      <h3 class="text-center text-secondary">Registro de personas</h3>

      <?php
      include "controller/crear_persona_controller.php";
      ?>

      <div class="mb-3">
        <label for="inputNombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="nombre">
      </div>
      <div class="mb-3">
        <label for="inputApellidos" class="form-label">Apellidos</label>
        <input type="text" class="form-control" name="apellidos">
      </div>
      <div class="mb-3">
        <label for="inputDNI" class="form-label">DNI</label>
        <input type="text" class="form-control" name="DNI">
      </div>
      <div class="mb-3">
        <label for="inputFecha" class="form-label">Fecha de nacimiento</label>
        <input type="date" class="form-control" name="fecha_nacimiento">
      </div>
      <div class="mb-3">
        <label for="inputEmail" class="form-label">Correo</label>
        <input type="email" class="form-control" name="correo">
      </div>
      <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button>
    </form>
    <div class="col-8 p-4">
      <table class="table">
        <thead class="bg-info">
          <tr>
            <th scope="col">#</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">APELLIDOS</th>
            <th scope="col">DNI</th>
            <th scope="col">FECHA DE NACIMIENTO</th>
            <th scope="col">CORREO</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          include("model/conexion.php");
          $sql = $conexion->query("SELECT * FROM personas");
          while ($datos = $sql->fetch_object()) { ?>
            <tr>
              <th scope="row"><?php echo $datos->id; ?></th>
              <td><?php echo $datos->nombre; ?></td>
              <td><?php echo $datos->apellidos; ?></td>
              <td><?php echo $datos->DNI; ?></td>
              <td><?php echo $datos->fecha_nacimiento; ?></td>
              <td><?php echo $datos->correo; ?></td>
              <td>
                <a href="actualizar_persona_view.php?id=<?=$datos->id?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                <a onclick="return eliminar()" href="index.php?id=<?=$datos->id?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
          <?php
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>