<?php
include("conexion.php");

// CORRECCIÓN: Ahora recibimos 'token', no 'id'
if (!isset($_GET['token'])) { 
    header("Location: index.php"); 
    exit(); 
}

$token = $conexion->real_escape_string($_GET['token']);

// Buscamos al asistente por su TOKEN ÚNICO
$sql = "SELECT * FROM asistentes WHERE token_unico = '$token'";
$resultado = $conexion->query($sql);
$asistente = $resultado->fetch_assoc();

if (!$asistente) { die("Ticket no encontrado"); }

// URL para generar el QR usando una API pública
$contenido_qr = $asistente['token_unico'];
$qr_api_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($contenido_qr);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Ticket - Fin de Ciclo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #1a1a2e; font-family: 'Inter', sans-serif; }
        .ticket-cut {
            border-bottom: 2px dashed #4b5563;
            position: relative;
        }
        .ticket-cut::before, .ticket-cut::after {
            content: ''; position: absolute; bottom: -10px; width: 20px; height: 20px;
            background-color: #1a1a2e; border-radius: 50%;
        }
        .ticket-cut::before { left: -10px; }
        .ticket-cut::after { right: -10px; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden">
        <div class="bg-purple-600 p-6 text-center text-white ticket-cut">
            <h2 class="text-2xl font-bold uppercase tracking-wider">Pase de Ingreso</h2>
            <p class="text-purple-200 text-sm mt-1">Fiesta Fin de Ciclo UNALM</p>
        </div>

        <div class="p-8 text-center bg-gray-100">
            <div class="mb-6 flex justify-center">
                <img src="<?php echo $qr_api_url; ?>" alt="Código QR" class="border-4 border-white shadow-lg rounded-lg">
            </div>

            <h3 class="text-xl font-bold text-gray-800">
                <?php echo $asistente['nombres'] . " " . $asistente['apellidos']; ?>
            </h3>
            <p class="text-gray-500 font-mono mt-1"><?php echo $asistente['codigo_alumno']; ?></p>
            
            <div class="mt-4 bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm inline-block font-bold">
                <?php echo $asistente['carrera']; ?>
            </div>
        </div>

        <div class="bg-gray-200 p-4 text-center border-t border-gray-300">
            <p class="text-xs text-gray-500">Muestra este QR en la entrada.</p>
            <p class="text-xs text-gray-400 mt-1">ID Único: <?php echo substr($asistente['token_unico'], 0, 15); ?>...</p>
        </div>
    </div>

    <div class="mt-8 flex gap-4">
        <a href="index.php" class="text-purple-400 hover:text-purple-300 font-semibold">← Registrar otro</a>
        <button onclick="window.print()" class="text-white hover:text-gray-300 font-semibold bg-gray-700 px-4 py-2 rounded">🖨 Imprimir</button>
    </div>

</body>
</html>