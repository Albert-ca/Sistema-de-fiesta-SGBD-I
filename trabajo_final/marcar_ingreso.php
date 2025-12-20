<?php
include("conexion.php"); //
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    // Actualizamos el estado
    mysqli_query($conexion, "UPDATE asistentes SET estado_ingreso = 'Ingresó' WHERE id = '$id'");
}
header("Location: lista_invitados.php");
?>