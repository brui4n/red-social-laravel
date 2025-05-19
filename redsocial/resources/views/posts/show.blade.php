@extends('layouts.app') <!-- o el layout que uses -->

@section('content')
    <h1>{{ $post->titulo }}</h1>
    <p>{{ $post->contenido }}</p>

    @if($post->imagen)
        <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post" style="max-width: 400px;">
    @endif

    @if($post->archivo)
        <p><a href="{{ asset('storage/' . $post->archivo) }}" target="_blank">Descargar archivo</a></p>
    @endif

    @if($post->codigo)
        <pre><code>{{ $post->codigo }}</code></pre>
    @endif

    @if($post->lenguaje)
        <p><strong>Lenguaje:</strong> {{ $post->lenguaje }}</p>
    @endif

    <hr>

    <h3>Comentarios</h3>
    @foreach($post->comentarios as $comentario)
        <p><strong>{{ $comentario->usuario->name ?? 'Anónimo' }}:</strong> {{ $comentario->contenido }}</p>
    @endforeach
@endsection
