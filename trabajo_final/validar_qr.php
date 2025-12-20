<?php
include("conexion.php");
$token = mysqli_real_escape_string($conexion, $_POST['token']);

$sql = "SELECT * FROM asistentes WHERE token_unico = '$token'";
$res = mysqli_query($conexion, $sql);
$alumno = mysqli_fetch_assoc($res);

if(!$alumno){
    echo "<body style='background:red; color:white; text-align:center; font-family:sans-serif; padding:50px;'>
          <h1>❌ TICKET INVÁLIDO</h1>
          <p>Este código no existe en la base de datos.</p>
          <a href='portero.php' style='color:white'>Volver a intentar</a></body>";
} elseif($alumno['estado_ingreso'] == 'Ingresó'){
    echo "<body style='background:orange; color:white; text-align:center; font-family:sans-serif; padding:50px;'>
          <h1>⚠️ ALERTA: TICKET DUPLICADO</h1>
          <p>El alumno <b>{$alumno['nombres']}</b> ya ingresó al evento anteriormente.</p>
          <a href='portero.php' style='color:white'>Volver a intentar</a></body>";
} else {
    mysqli_query($conexion, "UPDATE asistentes SET estado_ingreso = 'Ingresó' WHERE token_unico = '$token'");
    echo "<body style='background:green; color:white; text-align:center; font-family:sans-serif; padding:50px;'>
          <h1>✅ BIENVENIDO</h1>
          <p>Acceso permitido para: <b>{$alumno['nombres']}</b></p>
          <p>Zona: <b>Campo A</b></p>
          <a href='portero.php' style='color:white'>Siguiente</a></body>";
}
?>