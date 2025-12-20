<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - UNALM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-gray-800 p-8 rounded-3xl border-2 border-purple-500 shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-white italic tracking-tighter">SISTEMA ADMIN</h1>
            <p class="text-purple-400 text-sm">Ingresa tus credenciales de grupo</p>
        </div>

        <form action="auth.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-400 text-xs uppercase mb-2">Usuario</label>
                <input type="text" name="user" required class="w-full p-3 bg-gray-900 rounded-xl border border-gray-700 text-white outline-none focus:border-pink-500 transition">
            </div>
            <div>
                <label class="block text-gray-400 text-xs uppercase mb-2">Contraseña</label>
                <input type="password" name="pass" required class="w-full p-3 bg-gray-900 rounded-xl border border-gray-700 text-white outline-none focus:border-pink-500 transition">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 p-4 rounded-xl font-bold text-white shadow-lg hover:scale-105 transition">
                ENTRAR AL PANEL
            </button>
        </form>
    </div>
</body>
</html>