<?php
include("conexion.php"); //

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CORRECCIÓN: Quitamos el "_with_" de la función
    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo_alumno']);
    $nombres = mysqli_real_escape_string($conexion, $_POST['nombres']);
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $carrera = mysqli_real_escape_string($conexion, $_POST['carrera']);
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $id_zona = mysqli_real_escape_string($conexion, $_POST['id_zona']);

    // 1. VALIDACIÓN: ¿El alumno ya está registrado? (Por código o DNI)
    $check_alumno = mysqli_query($conexion, "SELECT id FROM asistentes WHERE codigo_alumno = '$codigo' OR dni = '$dni'");
    if (mysqli_num_rows($check_alumno) > 0) {
        header("Location: index.php?status=error&message=Ya existe un registro con este código o DNI.");
        exit();
    }

    // 2. VALIDACIÓN DE CUPOS: ¿Aún hay vacantes en la zona elegida?
    $sql_cupo = "SELECT (cupo_maximo - (SELECT COUNT(*) FROM asistentes WHERE id_zona = $id_zona)) as vacantes FROM zonas WHERE id = $id_zona";
    $res_cupo = mysqli_query($conexion, $sql_cupo);
    $fila_cupo = mysqli_fetch_assoc($res_cupo);

    if ($fila_cupo['vacantes'] <= 0) {
        header("Location: index.php?status=error&message=Lo sentimos, los cupos para esta zona se acaban de agotar.");
        exit();
    }

    // 3. REGISTRO: Guardamos al asistente
    // 3. REGISTRO: Guardamos al asistente
        $token = bin2hex(random_bytes(8)); 
            $sql_insert = "INSERT INTO asistentes (codigo_alumno, nombres, apellidos, dni, carrera, email, id_zona, token_unico) 
            VALUES ('$codigo', '$nombres', '$apellidos', '$dni', '$carrera', '$email', '$id_zona', '$token')";

    if (mysqli_query($conexion, $sql_insert)) {
        // Redirigimos a una página de éxito (puedes crear ticket.php luego)
        header("Location: ticket.php?token=$token");
    } else {
        header("Location: index.php?status=error&message=Error al procesar el registro.");
    }
}
?>