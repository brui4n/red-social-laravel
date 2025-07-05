<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CodeNet | Autenticación</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link rel="stylesheet" href="/build/assets/app-BzUvF4Py.css">
    <script src="/build/assets/app-CcSAaUhI.js" defer></script>
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) --> 

    <style>
        body {
            background: linear-gradient(to right, #e0f2ff, #f0f9ff); /* Celeste suave */
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col justify-center items-center">
        <div class="mb-4 text-center">
            <h1 class="text-4xl font-bold text-blue-700">Bienvenido a CodeNet 🚀</h1>
            <p class="text-sm text-gray-500">¡Conecta, comparte y codea!</p>
        </div>

        <div class="w-full sm:max-w-md mt-4 px-6 py-6 bg-white shadow-lg rounded-xl border border-blue-100">
            {{ $slot }}
        </div>

        <footer class="mt-8 text-sm text-gray-500">
            © {{ date('Y') }} CodeNet | Hecho con 💻 por estudiantes para estudiantes
        </footer>
    </div>

</body>
</html>
