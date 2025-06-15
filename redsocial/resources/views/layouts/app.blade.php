<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Red Social') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">
                <a href="{{ route('inicio') }}">Red Social 🔗</a>
            </h1>
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-red-600 hover:underline">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </header>

    <main class="max-w-4xl mx-auto py-6 px-4">
        @yield('content')
    </main>
</body>
</html>
