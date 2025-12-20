<?php
include("conexion.php"); //

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    
    // Primero consultamos el estado actual
    $check = mysqli_query($conexion, "SELECT estado_ingreso, nombres FROM asistentes WHERE id = '$id'");
    $asistente = mysqli_fetch_assoc($check);

    if($asistente['estado_ingreso'] == 'Ingresó'){
        // Si ya ingresó, mandamos un error por URL
        header("Location: lista_invitados.php?error=duplicado&nombre=" . urlencode($asistente['nombres']));
    } else {
        // Si estaba pendiente, marcamos el ingreso
        mysqli_query($conexion, "UPDATE asistentes SET estado_ingreso = 'Ingresó' WHERE id = '$id'");
        header("Location: lista_invitados.php?success=ingreso");
    }
} else {
    header("Location: lista_invitados.php");
}
?>
