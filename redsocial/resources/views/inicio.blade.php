@extends('layouts.app')

@section('content')
@auth
    {{-- Bienvenida + Filtro --}}
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">¡Hola, {{ Auth::user()->nombre }}! 👋</h1>
        <p class="text-gray-600 mt-2">Bienvenido a <span class="text-blue-600 font-semibold">CodeNet</span>. Comparte tus ideas, código y más.</p>
    </div>

    {{-- Filtro por etiqueta --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('inicio') }}" class="flex items-center gap-3 justify-center">
            <label for="tag" class="text-sm font-medium">Filtrar por etiqueta:</label>
            <select name="tag" id="tag" class="border rounded px-3 py-1 text-sm">
                <option value="">Todas</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white text-sm px-4 py-1 rounded hover:bg-blue-600">
                Filtrar
            </button>
        </form>
    </div>

    {{-- Lista de Posts --}}
    <div class="space-y-6">
        @if($posts->count())
            @foreach($posts as $post)
                <div class="bg-white shadow-md rounded-xl p-5 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">{{ $post->titulo }}</h3>
                    <p class="text-sm text-gray-500 mb-2">
                        Publicado por 
                        @if($post->user)
                            <a href="{{ route('profile.show', $post->user) }}" 
                               class="text-blue-600 hover:underline font-medium">
                                {{ $post->user->nombre }}
                            </a>
                        @else
                            <span class="text-gray-700">Usuario desconocido</span>
                        @endif
                    </p>
                    <p class="text-gray-700 mb-4">{{ Str::limit($post->contenido, 120) }}</p>

                    @if($post->imagen)
                        <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post"
                             class="rounded-lg mb-4 w-full max-h-64 object-contain" />
                    @endif

                    @if($post->tags->count())
                        <div class="mb-3">
                            @foreach($post->tags as $tag)
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs mr-1">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <a href="{{ route('posts.show', $post->id) }}"
                       class="inline-block text-sm text-blue-600 hover:underline">👁️ Ver más</a>
                </div>
            @endforeach
        @else
            <p class="text-gray-500 text-center">No hay posts todavía. ¡Sé el primero en publicar algo genial! 💡</p>
        @endif
    </div>
@endauth
@endsection

@section('sidebar')
<div class="bg-white border border-gray-200 shadow-2xl rounded-2xl p-6 space-y-6 text-sm">
    {{-- Cabecera --}}
    <div class="text-center">
        <h3 class="text-xl font-bold text-blue-700">⚡ Accesos rápidos</h3>
        <p class="text-gray-500 text-xs mt-1">Todo a un clic de distancia</p>
    </div>

    {{-- Links con tarjetas pequeñas --}}
    <div class="space-y-3">
        <a href="{{ route('profile.show', Auth::user()) }}"
           class="flex items-center gap-3 px-3 py-2 bg-gray-50 hover:bg-blue-50 border border-gray-100 rounded-lg transition">
            <span class="text-xl">👤</span>
            <span class="font-medium text-gray-800">Mi perfil</span>
        </a>

        <a href="{{ route('posts.create') }}"
           class="flex items-center gap-3 px-3 py-2 bg-gray-50 hover:bg-blue-50 border border-gray-100 rounded-lg transition">
            <span class="text-xl">📤</span>
            <span class="font-medium text-gray-800">Crear post</span>
        </a>

        <a href="{{ route('posts.mis_posts') }}"
           class="flex items-center gap-3 px-3 py-2 bg-gray-50 hover:bg-blue-50 border border-gray-100 rounded-lg transition">
            <span class="text-xl">📁</span>
            <span class="font-medium text-gray-800">Mis posts</span>
        </a>

        <a href="{{ route('notificaciones.index') }}"
           class="flex items-center gap-3 px-3 py-2 bg-gray-50 hover:bg-blue-50 border border-gray-100 rounded-lg transition">
            <span class="text-xl">🔔</span>
            <span class="font-medium text-gray-800">Notificaciones</span>
        </a>

        <a href="{{ route('mis.comentarios') }}"
           class="flex items-center gap-3 px-3 py-2 bg-gray-50 hover:bg-blue-50 border border-gray-100 rounded-lg transition">
            <span class="text-xl">💬</span>
            <span class="font-medium text-gray-800">Mis comentarios</span>
        </a>

        <a href="{{ route('posts.que_me_gustaron') }}"
           class="flex items-center gap-3 px-3 py-2 bg-gray-50 hover:bg-blue-50 border border-gray-100 rounded-lg transition">
            <span class="text-xl">❤️</span>
            <span class="font-medium text-gray-800">Posts que me gustaron</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-3 py-2 bg-gray-50 hover:bg-blue-50 border border-gray-100 rounded-lg transition">
            <span class="text-xl">⚙️</span>
            <span class="font-medium text-gray-800">Editar perfil</span>
        </a>
    </div>

    {{-- Mensaje inferior --}}
    <div class="bg-blue-50 text-blue-800 text-xs rounded-lg p-3 mt-4 border border-blue-100">
        🔍 Consejo: ¡Sigue a otros usuarios y recibe notificaciones cuando compartan algo nuevo!
    </div>
</div>
@endsection

