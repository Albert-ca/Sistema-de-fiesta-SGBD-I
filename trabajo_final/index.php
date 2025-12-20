<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fin de Ciclo 2025 - UNALM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Fondo animado estilo fiesta */
        body {
            background: linear-gradient(-45deg, #1a1a2e, #16213e, #0f3460, #4a1c40);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            font-family: 'Inter', sans-serif;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-gray-900 bg-opacity-80 p-8 rounded-2xl shadow-2xl w-full max-w-lg border border-purple-500">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
                🎉 FIN DE CICLO 2025
            </h1>
            <p class="text-gray-400 mt-2">Regístrate para obtener tu pase QR</p>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4 text-center">
                Error: <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <form action="guardar_registro.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-purple-300 text-sm font-bold mb-2">Código de Alumno</label>
                <input type="text" name="codigo_alumno" required placeholder="Ej: 20240001"
                    class="w-full p-3 rounded bg-gray-800 border border-gray-600 focus:border-purple-500 text-white outline-none transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-purple-300 text-sm font-bold mb-2">Nombres</label>
                    <input type="text" name="nombres" required
                        class="w-full p-3 rounded bg-gray-800 border border-gray-600 focus:border-purple-500 text-white outline-none">
                </div>
                <div>
                    <label class="block text-purple-300 text-sm font-bold mb-2">Apellidos</label>
                    <input type="text" name="apellidos" required
                        class="w-full p-3 rounded bg-gray-800 border border-gray-600 focus:border-purple-500 text-white outline-none">
                </div>
            </div>

            <div>
                <label class="block text-purple-300 text-sm font-bold mb-2">Carrera</label>
                <select name="carrera" required class="w-full p-3 rounded bg-gray-800 border border-gray-600 focus:border-purple-500 text-white outline-none">
                    <option value="">Selecciona tu carrera...</option>
                    <option value="Estadística Informática">Estadística Informática</option>
                    <option value="Agronomía">Agronomía</option>
                    <option value="Ingeniería Ambiental">Ingeniería Ambiental</option>
                    <option value="Zootecnia">Zootecnia</option>
                    <option value="Economía">Economía</option>
                    <option value="Otra">Otra</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-purple-300 text-sm font-bold mb-2">DNI</label>
                    <input type="number" name="dni" required
                        class="w-full p-3 rounded bg-gray-800 border border-gray-600 focus:border-purple-500 text-white outline-none">
                </div>
                <div>
                    <label class="block text-purple-300 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" required
                        class="w-full p-3 rounded bg-gray-800 border border-gray-600 focus:border-purple-500 text-white outline-none">
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-4 rounded-lg transform transition hover:scale-105 shadow-lg mt-6">
                🎫 GENERAR MI TICKET
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="lista_invitados.php" class="text-gray-500 hover:text-purple-400 text-sm underline">Ver lista de invitados (Admin)</a>
        </div>
    </div>
</body>
</html>