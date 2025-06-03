@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- Post --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h2 class="card-title">{{ $post->titulo }}</h2>
            <p class="card-text">{{ $post->contenido }}</p>
            
            @if($post->imagen)
                <div class="text-center my-3">
                    <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: contain;">
                </div>
            @endif

            @if($post->codigo)
                <pre class="bg-light p-3 rounded"><code>{{ $post->codigo }}</code></pre>
            @endif

            @if($post->lenguaje)
                <p><strong>Lenguaje:</strong> {{ $post->lenguaje }}</p>
            @endif

            <div class="d-flex flex-wrap gap-2 mt-4">
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        👍 {{ $post->likes->count() }} Me gusta
                    </button>
                </form>

                <button class="btn btn-outline-success btn-sm" onclick="copiarEnlace()">📤 Compartir</button>
            </div>
        </div>
    </div>

{{-- Comentarios --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h4 class="card-title">🗨️ Comentarios</h4>

        @if($post->comentarios->count())
            @foreach ($post->comentarios as $comentario)
                <div class="card mb-2">
                    <div class="card-body">
                        @if($comentario->usuario)
                            <div class="me-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comentario->usuario->nombre) }}&background=random&color=fff"
                                 alt="Avatar" class="rounded-circle" width="40" height="40">
                            </div>
                            <p class="mb-1"><strong>{{ $comentario->usuario->username }}</strong></p>
                        @else select * from usuarios;
                            <p class="mb-1"><strong class="text-muted">[Usuario eliminado]</strong></p>
                        @endif

                        {{-- Mostrar contenido del comentario --}}
                        <div id="contenido-comentario-{{ $comentario->id }}">
                            <p>{{ $comentario->contenido }}</p>
                        </div>

                        {{-- Formulario de edición (oculto por defecto) --}}
                        <form id="form-editar-{{ $comentario->id }}" action="{{ route('comentarios.update', $comentario) }}" method="POST" class="d-none mt-2">
                            @csrf
                            @method('PUT')
                            <textarea name="contenido" class="form-control" rows="2" required>{{ $comentario->contenido }}</textarea>
                            <div class="d-flex gap-2 mt-2">
                                <button type="submit" class="btn btn-success btn-sm">💾 Guardar</button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="cancelarEdicion({{ $comentario->id }})">Cancelar</button>
                            </div>
                        </form>

                        {{-- Botones de acción (visible solo si es su comentario) --}}
                        @if(auth()->check() && auth()->id() === $comentario->usuario_id)
                            <div class="d-flex gap-2 mt-2" id="acciones-comentario-{{ $comentario->id }}">
                                <button class="btn btn-outline-warning btn-sm" onclick="mostrarFormularioEdicion({{ $comentario->id }})">✏️ Editar</button>

                                <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" onsubmit="return confirm('¿Eliminar este comentario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">🗑️ Eliminar</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">Aún no hay comentarios.</p>
        @endif
    </div>
</div>



    {{-- Formulario para comentar --}}
    @auth
        <div class="card shadow-sm" id="comentar">
            <div class="card-body">
                <form action="{{ route('comentarios.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="contenido" class="form-control" rows="2" placeholder="Escribe un comentario..." required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-sm">💬 Comentar</button>
                        <a href="{{ route('inicio') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    @else
        <p class="text-muted">Debes iniciar sesión para comentar.</p>
    @endauth
</div>

<script>
    function copiarEnlace() {
        navigator.clipboard.writeText("{{ route('posts.show', $post->id) }}");
        alert("¡Enlace copiado al portapapeles!");
    }

    function mostrarFormularioEdicion(id) {
        document.getElementById('contenido-comentario-' + id).classList.add('d-none');
        document.getElementById('form-editar-' + id).classList.remove('d-none');
        document.getElementById('acciones-comentario-' + id).classList.add('d-none');
    }

    function cancelarEdicion(id) {
        document.getElementById('contenido-comentario-' + id).classList.remove('d-none');
        document.getElementById('form-editar-' + id).classList.add('d-none');
        document.getElementById('acciones-comentario-' + id).classList.remove('d-none');
    }
</script>


@endsection
