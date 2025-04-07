<?php
if(!empty($_POST['btnactualizar'])){
    include("model/conexion.php");
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $DNI = $_POST['DNI'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];

    $sql = $conexion->query("UPDATE personas SET nombre='$nombre', apellidos='$apellidos', DNI='$DNI', fecha_nacimiento='$fecha_nacimiento', correo='$correo' WHERE id='$id'");

    if($sql == 1){
        header("location: index.php?mensaje=modificado");
    }else{
         echo "<div class='alert alert-danger'>Error al modificar el registro</div>";
    }
}
?>