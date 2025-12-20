<?php
// conexion.php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombre_bd = "fiesta_unalm"; // Cambiamos a la nueva BD

$conexion = new mysqli($servidor, $usuario, $contraseña, $nombre_bd);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");
?>