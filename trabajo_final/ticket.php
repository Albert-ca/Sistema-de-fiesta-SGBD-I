<?php
include("conexion.php"); //

if (!isset($_GET['id'])) { header("Location: index.php"); exit(); }

$id = $conexion->real_escape_string($_GET['id']);

$sql = "SELECT a.*, z.nombre AS zona_nombre 
        FROM asistentes a 
        INNER JOIN zonas z ON a.id_zona = z.id 
        WHERE a.id = '$id'";

$resultado = $conexion->query($sql);
$asistente = $resultado->fetch_assoc();

if (!$asistente) { die("Ticket no encontrado"); }

$contenido_qr = "Ticket UNALM: " . $asistente['nombres'] . " | DNI: " . $asistente['dni'] . " | Zona: " . $asistente['zona_nombre'];
$qr_api_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($contenido_qr);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket Digital - <?php echo $asistente['nombres']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f172a; font-family: 'Inter', sans-serif; }
        .ticket-shape {
            clip-path: polygon(10% 0, 90% 0, 100% 10%, 100% 70%, 95% 75%, 100% 80%, 100% 100%, 0 100%, 0 80%, 5% 75%, 0 70%, 0 10%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6 text-white">

    <div class="max-w-sm w-full bg-gray-900 rounded-3xl border-2 border-pink-500 shadow-2xl overflow-hidden ticket-shape">
        <div class="bg-gradient-to-r from-purple-700 to-pink-600 p-6 text-center">
            <h1 class="text-xl font-black uppercase tracking-tighter italic">Pase de Ingreso</h1>
            <p class="text-xs text-purple-200">FIN DE CICLO 2025 - UNALM</p>
        </div>

        <div class="p-8 text-center">
            <div class="mb-6 flex justify-center">
                <div class="bg-white p-3 rounded-xl shadow-inner">
                    <img src="<?php echo $qr_api_url; ?>" alt="Código QR" class="w-40 h-40">
                </div>
            </div>

            <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400">
                <?php echo $asistente['nombres'] . " " . $asistente['apellidos']; ?>
            </h2>
            <p class="text-pink-400 font-mono text-sm tracking-widest mt-1"><?php echo $asistente['codigo_alumno']; ?></p>

            <div class="mt-6 py-3 px-6 bg-gray-800 rounded-lg border border-gray-700">
                <p class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">Ubicación</p>
                <p class="text-xl font-black text-yellow-400"><?php echo strtoupper($asistente['zona_nombre']); ?></p>
            </div>
            
            <p class="mt-4 text-[10px] text-gray-500 italic">ID de Validación: <?php echo $asistente['token_unico']; ?></p>
        </div>

        <div class="bg-gray-800 p-4 text-center border-t-2 border-dashed border-gray-700">
            <p class="text-[10px] text-gray-400">Presentar DNI físico al ingresar • No transferible</p>
        </div>
    </div>

    <div class="mt-10 flex gap-4">
        <button onclick="window.print()" class="px-8 py-3 bg-white text-black font-bold rounded-full hover:scale-105 transition active:bg-gray-200">
            🖨️ IMPRIMIR PASE
        </button>
        <a href="index.php" class="px-8 py-3 bg-gray-800 text-purple-400 font-bold rounded-full border border-purple-500 hover:bg-purple-900 transition">
            REGISTRAR OTRO
        </a>
    </div>

</body>
</html>