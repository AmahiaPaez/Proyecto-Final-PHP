<?php
include("conexion.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $tipoPlan = trim($_POST['tipoPlan']);

    if (!empty($email) && !empty($tipoPlan)) {
        $consulta = "SELECT * FROM servicios INNER JOIN contacto ON contacto.id = servicios.id WHERE contacto.emailUsuario = ?";
        $stmt = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            $actualizar = "UPDATE servicios INNER JOIN contacto ON contacto.id = servicios.id 
                            SET servicios.planUsuario = ? WHERE contacto.emailUsuario = ?";
            $stmt_update = mysqli_prepare($conexion, $actualizar);
            mysqli_stmt_bind_param($stmt_update, "ss", $tipoPlan, $email);
            $ejecutar = mysqli_stmt_execute($stmt_update);

            if ($ejecutar) {
                echo "<div class='mensaje'>Plan actualizado correctamente.</div>";
                echo "<a href='index.php'><button class='boton'>Volver a la página principal</button></a>";
            } else {
                echo "<div class='mensaje'>Error al actualizar el plan: " . mysqli_error($conexion) . "</div>";
                echo "<a href='index.php'><button class='boton'>Volver a la página principal</button></a>";
            }
        } else {
            echo "<div class='mensaje'>No se encontró un usuario con el correo proporcionado.</div>";
            echo "<a href='index.php'><button class='boton'>Volver a la página principal</button></a>";
        }

        mysqli_stmt_close($stmt);
        if (isset($stmt_update)) {
            mysqli_stmt_close($stmt_update);
        }
    } else {
        echo "<div class='mensaje'>Por favor completa todos los campos.</div>";
        echo "<a href='index.php'><button class='boton'>Volver a la página principal</button></a>";
    }
} else {
    echo "<div class='mensaje'>Método de solicitud no válido.</div>";
    echo "<a href='index.php' class='boton_redireccion'><button class='boton'>Volver a la página principal</button></a>";
}

// 6. Cerrar la conexión
mysqli_close($conexion);
?>

<style>
    body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh; 
        margin: 0;
        font-family: Arial, sans-serif;
        text-align: center; 
    }

    .mensaje {
        margin-bottom: 20px; 
        font-size: 18px; 
    }

    .boton {
        background: linear-gradient(145deg, #41285b 0%,
                #1e2d6d 100%);
        color: white; 
        border: none; 
        padding: 10px 20px; 
        text-align: center; 
        text-decoration: none; 
        display: inline-block; 
        font-size: 16px; 
        margin: 4px 2px; 
        cursor: pointer; 
        border-radius: 5px; 
        transition: background-color 0.3s; 
    }

    .boton:hover {
        background: linear-gradient(145deg, #41285b 0%,
                #1e2d6d 100%);}
</style>
