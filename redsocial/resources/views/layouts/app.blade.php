<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Red Social') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- 👈 Faltaba este -->
    
    <link rel="stylesheet" href="/build/assets/app-BzUvF4Py.css">
    <script src="/build/assets/app-82Xx5nQG.js" defer></script>
    

    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    @auth
        <script>
            window.Laravel = {!! json_encode([
                'userId' => auth()->user()->id,
            ]) !!};
        </script>
    @endauth

</head>
<body class="bg-gray-100 text-gray-900 font-sans">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">
                <a href="{{ route('inicio') }}">Red Social 🔗</a>
            </h1>
            @auth
                <div class="flex items-center gap-4">
                    <!-- Campanita -->
                    <div class="relative">
                        <button id="boton-notificaciones" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                            🔔
                            @if(auth()->user()->unreadNotifications->count())
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        <!-- Dropdown de notificaciones -->
                        <div id="dropdown-notificaciones" class="hidden absolute right-0 mt-2 w-72 bg-white border border-gray-300 rounded shadow-lg z-50">
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Notificaciones</h3>
                                <form method="POST" action="{{ route('notificaciones.marcarLeidas') }}" class="mb-3">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="text-xs bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition-all shadow-sm"
                                    >
                                        ✔ Marcar todas como leídas
                                    </button>
                                </form>
                                <div class="text-center mt-2">
                                    <a href="{{ route('notificaciones.index') }}" class="text-sm text-blue-600 hover:underline">
                                        Ver todas las notificaciones →
                                    </a>
                                </div>


                                @forelse(auth()->user()->notifications->take(5) as $notification)
                                    <div class="relative group">
                                        {{-- Botón de eliminar (solo visible al pasar el mouse) --}}
                                        <form method="POST" action="{{ route('notificaciones.eliminar', $notification->id) }}"
                                            class="absolute top-1 right-1 hidden group-hover:block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 text-xs hover:text-red-700">❌</button>
                                        </form>

                                        {{-- Contenido de la notificación --}}
                                        @php
                                            $esNoLeida = $notification->read_at === null;
                                        @endphp

                                        <a href="{{ route('posts.show', $notification->data['post_id']) }}"
                                            class="block text-sm text-gray-800 border-b border-gray-200 py-2 hover:bg-gray-100 transition pr-6 {{ $esNoLeida ? 'bg-blue-100' : 'bg-white' }}">

                                            <strong>
                                                {{ $notification->data['usuario_comentario'] ?? $notification->data['usuario_like'] ?? 'Alguien' }}
                                            </strong>
                                            {{ isset($notification->data['usuario_comentario']) ? 'comentó tu post:' : 'le dio like a tu post.' }}
                                            <br>
                                            <span class="text-gray-600">
                                                {{ $notification->data['mensaje'] ?? 'Tienes una nueva notificación' }}
                                            </span>
                                        </a>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Sin notificaciones.</p>
                                @endforelse




                            </div>
                        </div>
                    </div>

                    <!-- Botón de cerrar sesión -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-red-600 hover:underline">Cerrar sesión</button>
                    </form>
                </div>
            @endauth

        </div>
    </header>

    <main class="flex justify-center gap-6 px-6 py-8 relative">

        {{-- Contenido principal (posts, etc.) --}}
        <div class="w-full max-w-4xl">
            @yield('content')
        </div>

        {{-- Panel lateral derecho (sidebar) --}}
        @hasSection('sidebar')
            <aside class="hidden lg:block w-64 sticky top-32 self-start">
                @yield('sidebar')
            </aside>
        @endif

    </main>

    <script>
        const dropdown = document.getElementById('dropdown-notificaciones');
        const boton = document.getElementById('boton-notificaciones');

        boton?.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!event.target.closest('#dropdown-notificaciones') && !event.target.closest('#boton-notificaciones')) {
                dropdown?.classList.add('hidden');
            }
        });
    </script>


        {{-- 🚨 Aquí va el toast visual para notificaciones --}}
    @if(session('toast'))
        <div id="toast" class="fixed top-5 right-5 bg-blue-500 text-white px-4 py-2 rounded shadow-lg z-50 animate-fade-in-out">
            {{ session('toast') }}
        </div>
    @endif

    <style>
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }
        .animate-fade-in-out {
            animation: fadeInOut 3s ease-in-out forwards;
        }
    </style>

</body>
</html>
