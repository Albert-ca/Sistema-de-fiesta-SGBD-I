<?php
session_start();
include("conexion.php"); //

$user = mysqli_real_escape_string($conexion, $_POST['user']);
$pass = mysqli_real_escape_string($conexion, $_POST['pass']);

$sql = "SELECT * FROM usuarios_admin WHERE usuario = '$user' AND password = '$pass'";
$res = mysqli_query($conexion, $sql);

if(mysqli_num_rows($res) > 0){
    $_SESSION['admin_logeado'] = true;
    header("Location: lista_invitados.php");
} else {
    header("Location: login.php?error=1");
}
?>