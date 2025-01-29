<?php
include("conexion.php");

if (isset($_POST['register'])) {
    // Verificar que todos los campos estén llenos
    if (
        !empty($_POST['nombre']) &&
        !empty($_POST['email']) &&
        !empty($_POST['telefono']) &&
        !empty($_POST['departamento']) &&
        !empty($_POST['tipoPlan']) &&
        !empty($_POST['tipoServicio']) &&
        !empty($_POST['descripcion']) &&
        !empty($_POST['prioridad'])
    ) {
        // Sanitizar los datos
        $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
        $email = mysqli_real_escape_string($conexion, trim($_POST['email']));
        $telefono = mysqli_real_escape_string($conexion, trim($_POST['telefono']));
        $departamento = mysqli_real_escape_string($conexion, trim($_POST['departamento']));
        $tipoPlan = mysqli_real_escape_string($conexion, trim($_POST['tipoPlan']));
        $tipoServicio = mysqli_real_escape_string($conexion, trim($_POST['tipoServicio']));
        $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion']));
        $prioridad = mysqli_real_escape_string($conexion, trim($_POST['prioridad']));

        // Iniciar una transacción
        mysqli_begin_transaction($conexion);
        try {
            // Insertar en la tabla `contacto`
            $query_contacto = "INSERT INTO contacto(nombreUsuario, emailUsuario, telefonoUsuario, departamento) 
                                VALUES ('$nombre', '$email', '$telefono', '$departamento')";
            mysqli_query($conexion, $query_contacto);

            // Insertar en la tabla `problema`
            $query_problema = "INSERT INTO problema(descripcion, prioridad) 
                                VALUES ('$descripcion', '$prioridad')";
            mysqli_query($conexion, $query_problema);

            // Insertar en la tabla `servicios`
            $query_servicios = "INSERT INTO servicios(planUsuario, tipoServicio) 
                                VALUES ('$tipoPlan', '$tipoServicio')";
            mysqli_query($conexion, $query_servicios);

            // Confirmar transacción
            mysqli_commit($conexion);

            echo "Datos registrados exitosamente.";
        } catch (Exception $e) {
            // Revertir cambios si hay un error
            mysqli_rollback($conexion);
            echo "Error al registrar los datos: " . $e->getMessage();
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>
