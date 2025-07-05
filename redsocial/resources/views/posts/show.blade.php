@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    {{-- Post --}}
    <div class="bg-white p-6 rounded-xl shadow-md mb-6 border border-gray-200">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $post->titulo }}</h2>
        <p class="text-gray-700 mb-4">{{ $post->contenido }}</p>

        @if($post->imagen)
            <div class="text-center my-4">
                <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post"
                     class="rounded-lg shadow max-h-96 w-full object-contain">
            </div>
        @endif

        @if($post->codigo)
            <div class="bg-gray-900 text-green-200 text-sm font-mono rounded p-4 overflow-x-auto mb-4">
                <pre><code>{{ $post->codigo }}</code></pre>
            </div>
        @endif

        @if($post->lenguaje)
            <p class="text-sm text-gray-600"><strong>Lenguaje:</strong> {{ $post->lenguaje }}</p>
        @endif

        <div class="flex flex-wrap gap-4 mt-6">
            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                @csrf
                <button type="submit"
                        class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full hover:bg-blue-200 transition">
                    👍 {{ $post->users_liked->count() }} {{ Str::plural('Me gusta', $post->users_liked->count()) }}
                </button>
            </form>

            <button onclick="copiarEnlace()"
                    class="bg-green-100 text-green-700 px-4 py-1 rounded-full hover:bg-green-200 transition">
                📤 Compartir
            </button>
        </div>
    </div>

    {{-- Comentarios --}}
    <div class="bg-white p-6 rounded-xl shadow-md mb-6 border border-gray-200">
        <h3 class="text-2xl font-semibold mb-4">🗨️ Comentarios</h3>

        @if($post->comentarios->count())
            @foreach ($post->comentarios as $comentario)
                <div class="bg-gray-50 rounded-lg p-4 mb-3 shadow-sm border">
                    <div class="flex items-start gap-3 mb-2">
                        @if($comentario->user)
                            <img src="{{ $comentario->user->avatar 
                                        ? asset('storage/' . $comentario->user->avatar) 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($comentario->user->nombre) . '&background=random&color=fff' }}"
                                 alt="Avatar"
                                 class="w-10 h-10 rounded-full object-cover border border-gray-300">

                            <div>
                                <p class="font-bold text-sm text-gray-700">
                                    {{ $comentario->user->nombre }}
                                    <span class="text-gray-500 text-xs">({{ '@' . $comentario->user->username }})</span>
                                </p>
                                <p class="text-xs text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">[Usuario eliminado]</p>
                        @endif
                    </div>

                    <div id="contenido-comentario-{{ $comentario->id }}" class="text-gray-800 mb-2">
                        <p>{{ $comentario->contenido }}</p>
                    </div>

                    {{-- Formulario de edición --}}
                    <form id="form-editar-{{ $comentario->id }}" action="{{ route('comentarios.update', $comentario) }}" method="POST" class="hidden mt-2">
                        @csrf
                        @method('PUT')
                        <textarea name="contenido" class="w-full p-2 border rounded text-sm" rows="2" required>{{ $comentario->contenido }}</textarea>
                        <div class="flex gap-2 mt-2">
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm">💾 Guardar</button>
                            <button type="button" onclick="cancelarEdicion({{ $comentario->id }})"
                                    class="bg-gray-300 text-gray-700 px-3 py-1 rounded text-sm">Cancelar</button>
                        </div>
                    </form>

                    {{-- Acciones --}}
                    @if(auth()->check() && auth()->id() === $comentario->user_id)
                        <div class="flex gap-2 mt-2" id="acciones-comentario-{{ $comentario->id }}">
                            <button class="text-yellow-600 hover:underline text-sm"
                                    onclick="mostrarFormularioEdicion({{ $comentario->id }})">✏️ Editar</button>

                            <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este comentario?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-sm">🗑️ Eliminar</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <p class="text-gray-500">Aún no hay comentarios.</p>
        @endif
    </div>

    {{-- Formulario de comentar --}}
    @auth
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <form action="{{ route('comentarios.store', $post->id) }}" method="POST">
                @csrf
                <textarea name="contenido" class="w-full p-3 border border-gray-300 rounded mb-4" rows="3"
                          placeholder="Escribe un comentario..." required></textarea>
                <div class="flex justify-end gap-2">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">💬 Comentar</button>
                    <a href="{{ route('inicio') }}"
                       class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 text-sm">Cancelar</a>
                </div>
            </form>
        </div>
    @else
        <p class="text-gray-500 text-center">Debes iniciar sesión para comentar.</p>
    @endauth
</div>

<script>
    function copiarEnlace() {
        navigator.clipboard.writeText("{{ route('posts.show', $post->id) }}");
        alert("¡Enlace copiado al portapapeles!");
    }

    function mostrarFormularioEdicion(id) {
        document.getElementById('contenido-comentario-' + id).classList.add('hidden');
        document.getElementById('form-editar-' + id).classList.remove('hidden');
        document.getElementById('acciones-comentario-' + id).classList.add('hidden');
    }

    function cancelarEdicion(id) {
        document.getElementById('contenido-comentario-' + id).classList.remove('hidden');
        document.getElementById('form-editar-' + id).classList.add('hidden');
        document.getElementById('acciones-comentario-' + id).classList.remove('hidden');
    }
</script>
@endsection
