<?php
include("conexion.php");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=lista_invitados_unalm.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Codigo', 'Nombre', 'Apellidos', 'DNI', 'Carrera', 'Email', 'Zona', 'Estado'));

$query = "SELECT a.id, a.codigo_alumno, a.nombres, a.apellidos, a.dni, a.carrera, a.email, z.nombre, a.estado_ingreso 
          FROM asistentes a JOIN zonas z ON a.id_zona = z.id";
$rows = mysqli_query($conexion, $query);

while($row = mysqli_fetch_assoc($rows)) {
    fputcsv($output, $row);
}
fclose($output);
?>