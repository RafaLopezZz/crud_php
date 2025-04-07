<?php

if(!empty($_POST['btnregistrar'])){
    if(!empty($_POST["nombre"]) and !empty($_POST["apellidos"]) and !empty($_POST["DNI"]) and !empty($_POST["fecha_nacimiento"]) and !empty($_POST["correo"])) {
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $dni = $_POST["DNI"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $correo = $_POST["correo"];

        $sql = $conexion->query("INSERT INTO personas (nombre, apellidos, DNI, fecha_nacimiento, correo) VALUES ('$nombre', '$apellidos', '$dni', '$fecha_nacimiento', '$correo')");
        if($sql==1){
            echo "<div class='alert alert-success'>Registro exitoso</div>";
        } else {
            echo "<div class='alert alert-danger'>Error en el registro</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Alguno de los campos está vacío</div>";
    }
}

?>