<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Invitados</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-purple-400">📋 Lista de Asistentes</h2>
            <a href="index.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Nuevo Registro</a>
        </div>

        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-purple-900 text-purple-100">
                        <th class="p-4">ID</th>
                        <th class="p-4">Código</th>
                        <th class="p-4">Nombre Completo</th>
                        <th class="p-4">Carrera</th>
                        <th class="p-4">Fecha Registro</th>
                        <th class="p-4">QR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM asistentes ORDER BY id DESC";
                    $res = $conexion->query($sql);
                    while($row = $res->fetch_assoc()):
                    ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                        <td class="p-4"><?php echo $row['id']; ?></td>
                        <td class="p-4 font-mono text-yellow-400"><?php echo $row['codigo_alumno']; ?></td>
                        <td class="p-4"><?php echo $row['nombres'] . ' ' . $row['apellidos']; ?></td>
                        <td class="p-4"><?php echo $row['carrera']; ?></td>
                        <td class="p-4 text-sm text-gray-400"><?php echo $row['fecha_registro']; ?></td>
                        <td class="p-4">
                            <a href="ticket.php?id=<?php echo $row['id']; ?>" class="text-blue-400 hover:underline">Ver Ticket</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>