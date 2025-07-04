@extends('layouts.app')

@section('content')
@auth
<div class="max-w-4xl mx-auto px-4 py-8 text-center">
    <h1 class="text-4xl font-bold mb-2 text-gray-800">¡Hola, {{ Auth::user()->nombre }}! 👋</h1>
    <p class="text-gray-600 mb-6">Estás dentro de <span class="font-semibold text-blue-600">CodeNet</span>. Comparte tu código, ideas y proyectos.</p>

    <div class="flex flex-wrap justify-center gap-4 mb-8">
        <a href="{{ route('posts.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition">📤 Crear Post</a>
        <a href="{{ route('posts.mis_posts') }}"
            class="bg-white border border-blue-600 text-blue-600 px-5 py-2 rounded-lg hover:bg-blue-50 transition">📁 Mis Posts</a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg shadow-md transition">🚪 Cerrar sesión</button>
        </form>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">📰 Posts recientes</h2>

    @if($posts->count())
        <div class="grid gap-6">
            @foreach($posts as $post)
                <div class="bg-white shadow-md rounded-xl p-5 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">{{ $post->titulo }}</h3>
                    <p class="text-sm text-gray-500 mb-2">Publicado por <span class="font-medium text-gray-700">{{ $post->usuario->nombre ?? 'Usuario desconocido' }}</span></p>
                    <p class="text-gray-700 mb-4">{{ Str::limit($post->contenido, 120) }}</p>

                    @if($post->imagen)
                        <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post"
                             class="rounded-lg mb-4 max-h-48 object-cover w-full">
                    @endif

                    <a href="{{ route('posts.show', $post->id) }}"
                        class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-4 py-2 rounded transition">👁️ Ver más</a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No hay posts todavía. ¡Sé el primero en publicar! 💡</p>
    @endif
</div>
@endauth
@endsection
