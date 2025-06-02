@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mis Publicaciones</h2>

    @if($posts->isEmpty())
        <p>No has publicado nada aún.</p>
    @else
        <ul class="list-group">
            @foreach ($posts as $post)
                <li class="list-group-item mb-3">
                    <h4>{{ $post->titulo }}</h4>
                    <p>{{ Str::limit($post->contenido, 150) }}</p>

                    @if($post->imagen)
                        <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post" style="max-width: 200px;" class="mb-2">
                    @endif

                    @if($post->archivo)
                        <p><a href="{{ asset('storage/' . $post->archivo) }}" target="_blank" download>Descargar archivo</a></p>
                    @endif

                    @if($post->codigo)
                        <pre style="background:#f4f4f4; padding:10px; overflow-x:auto;">
                            <code>{{ $post->codigo }}</code>
                        </pre>
                        <small>Código en: {{ $post->lenguaje ?? 'No especificado' }}</small>
                    @endif

                    <div class="mt-2">
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    <a href="{{ route('inicio') }}" class="btn btn-primary mt-3">← Volver a la página principal</a>
</div>
@endsection
