<?php
include("conexion.php"); //

// PUNTO 3: Lógica de Búsqueda y Filtros
$search = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$filtro_zona = isset($_GET['zona']) ? mysqli_real_escape_string($conexion, $_GET['zona']) : '';

// Consulta principal con filtros
$sql = "SELECT a.*, z.nombre as zona_nombre 
        FROM asistentes a 
        JOIN zonas z ON a.id_zona = z.id 
        WHERE (a.nombres LIKE '%$search%' OR a.dni LIKE '%$search%' OR a.codigo_alumno LIKE '%$search%')";

if ($filtro_zona != '') {
    $sql .= " AND a.id_zona = '$filtro_zona'";
}
$sql .= " ORDER BY a.fecha_registro DESC";
$resultado = mysqli_query($conexion, $sql);

// PUNTO 1: Estadísticas para el Dashboard
$stats_zonas = mysqli_query($conexion, "SELECT z.nombre, z.cupo_maximo, (SELECT COUNT(*) FROM asistentes WHERE id_zona = z.id) as ocupados FROM zonas z");
$total_ingresaron = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM asistentes WHERE estado_ingreso = 'Ingresó'"))['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - UNALM 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <?php while($s = mysqli_fetch_assoc($stats_zonas)): 
                $porcentaje = ($s['ocupados'] / $s['cupo_maximo']) * 100; ?>
                <div class="bg-gray-800 p-4 rounded-xl border border-gray-700">
                    <p class="text-gray-400 text-xs uppercase"><?php echo $s['nombre']; ?></p>
                    <p class="text-2xl font-bold"><?php echo $s['ocupados']; ?> / <?php echo $s['cupo_maximo']; ?></p>
                    <div class="w-full bg-gray-700 h-2 rounded-full mt-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: <?php echo $porcentaje; ?>%"></div>
                    </div>
                </div>
            <?php endwhile; ?>
            <div class="bg-purple-900 p-4 rounded-xl border border-purple-500">
                <p class="text-purple-200 text-xs uppercase">Asistencia Real (En Puerta)</p>
                <p class="text-2xl font-bold"><?php echo $total_ingresaron; ?> Alumnos</p>
            </div>
        </div>

        <form method="GET" class="flex flex-wrap gap-4 mb-6 bg-gray-800 p-4 rounded-xl border border-gray-700">
            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Buscar por DNI, Nombre o Código..." 
                   class="flex-1 bg-gray-900 border border-gray-600 p-2 rounded text-sm outline-none focus:border-purple-500">
            <select name="zona" class="bg-gray-900 border border-gray-600 p-2 rounded text-sm outline-none">
                <option value="">Todas las zonas</option>
                <option value="1" <?php if($filtro_zona=='1') echo 'selected'; ?>>Campo A</option>
                <option value="2" <?php if($filtro_zona=='2') echo 'selected'; ?>>Campo B</option>
            </select>
            <button type="submit" class="bg-purple-600 px-6 py-2 rounded font-bold hover:bg-purple-700 transition">🔍 FILTRAR</button>
            <a href="exportar_csv.php" class="bg-green-600 px-6 py-2 rounded font-bold hover:bg-green-700 transition text-center">📥 EXCEL</a>
        </form>

        <div class="bg-gray-800 rounded-xl overflow-hidden border border-gray-700">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-700 text-gray-300 uppercase text-[10px]">
                    <tr>
                        <th class="p-4">Alumno</th>
                        <th class="p-4">Zona</th>
                        <th class="p-4">Estado</th>
                        <th class="p-4">Acción en Puerta</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr class="hover:bg-gray-750 transition">
                        <td class="p-4">
                            <span class="font-bold block"><?php echo $row['nombres']; ?></span>
                            <span class="text-gray-500 text-xs"><?php echo $row['dni']; ?> | <?php echo $row['carrera']; ?></span>
                        </td>
                        <td class="p-4"><span class="text-yellow-500 font-bold"><?php echo $row['zona_nombre']; ?></span></td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded text-[10px] font-bold <?php echo $row['estado_ingreso'] == 'Ingresó' ? 'bg-green-900 text-green-300' : 'bg-gray-700 text-gray-400'; ?>">
                                <?php echo strtoupper($row['estado_ingreso']); ?>
                            </span>
                        </td>
                        <td class="p-4">
                            <?php if($row['estado_ingreso'] == 'Pendiente'): ?>
                                <a href="marcar_ingreso.php?id=<?php echo $row['id']; ?>" class="bg-green-600 hover:bg-green-500 px-3 py-1 rounded text-xs font-bold text-white transition">✓ ENTRÓ</a>
                            <?php else: ?>
                                <span class="text-gray-600 text-xs italic">Ya ingresó</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>