<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $conexion->real_escape_string($_POST['codigo_alumno']);
    $nombres = $conexion->real_escape_string($_POST['nombres']);
    $apellidos = $conexion->real_escape_string($_POST['apellidos']);
    $carrera = $conexion->real_escape_string($_POST['carrera']);
    $dni = $conexion->real_escape_string($_POST['dni']);
    $email = $conexion->real_escape_string($_POST['email']);

    // Generar un string único para el QR (Ej: FIESTA2025-CODIGO-TIMESTAMP)
    $token_qr = "UNALM-FIESTA-" . $codigo . "-" . time();

    // Verificamos si ya existe el código para no duplicar
    $check = $conexion->query("SELECT id FROM asistentes WHERE codigo_alumno = '$codigo'");
    if($check->num_rows > 0){
         header("Location: index.php?status=error&message=" . urlencode("Este código de alumno ya está registrado."));
         exit();
    }

    $sql = "INSERT INTO asistentes (codigo_alumno, nombres, apellidos, carrera, dni, email, token_unico) 
            VALUES ('$codigo', '$nombres', '$apellidos', '$carrera', '$dni', '$email', '$token_qr')";

    if ($conexion->query($sql) === TRUE) {
        // Redirigir a la página del TICKET enviando el ID recién creado
        $last_id = $conexion->insert_id;
        header("Location: ticket.php?id=" . $last_id);
        exit();
    } else {
        header("Location: index.php?status=error&message=" . urlencode($conexion->error));
        exit();
    }
    $conexion->close();
}
?>