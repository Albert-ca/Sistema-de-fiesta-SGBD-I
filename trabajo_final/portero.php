<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Scanner de Puerta - UNALM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-gray-800 p-8 rounded-3xl border-2 border-purple-500 shadow-2xl text-center">
        <h1 class="text-2xl font-bold mb-6 italic">CONTROL DE ACCESO</h1>
        
        <form action="validar_qr.php" method="POST" class="space-y-4">
            <input type="text" name="token" placeholder="Escanea el código del ticket..." 
                   class="w-full p-4 bg-gray-900 rounded-xl border border-gray-600 focus:border-pink-500 outline-none text-center text-xl font-mono" autofocus>
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 p-4 rounded-xl font-bold uppercase tracking-widest">
                Verificar Entrada
            </button>
        </form>

        <div class="mt-8">
            <a href="lista_invitados.php" class="text-gray-500 hover:text-white text-sm">Volver al Panel</a>
        </div>
    </div>
</body>
</html>