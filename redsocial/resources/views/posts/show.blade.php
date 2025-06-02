@extends('layouts.app')

@section('content')
<div class="container mt-4">
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

            {{-- Botones: Like + Compartir + (si autenticado) Comentar --}}
            <div class="d-flex flex-wrap gap-2 mt-4">
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        👍 {{ $post->likes->count() }} Me gusta
                    </button>
                </form>

                <button class="btn btn-outline-success btn-sm" onclick="copiarEnlace()">📤 Compartir</button>
            </div>

            <script>
                function copiarEnlace() {
                    navigator.clipboard.writeText("{{ route('posts.show', $post->id) }}");
                    alert("¡Enlace copiado al portapapeles!");
                }
            </script>
        </div>
    </div>

    {{-- Comentarios --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title">🗨️ Comentarios</h4>

            @if($post->comentarios->count())
                @foreach($post->comentarios as $comentario)
                    <div class="d-flex align-items-start mb-3">
                        <div class="me-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comentario->usuario->nombre) }}&background=random&color=fff"
                                 alt="Avatar" class="rounded-circle" width="40" height="40">
                        </div>
                        <div>
                            <strong>{{ $comentario->usuario->nombre }}</strong><br>
                            <span>{{ $comentario->contenido }}</span>
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
                    <a href="{{ route('inicio') }}" class="btn btn-danger mt-3">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    @else
        <p class="text-muted">Debes iniciar sesión para comentar.</p>
    @endauth
</div>
@endsection
