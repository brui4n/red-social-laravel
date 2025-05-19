@extends('layouts.app') <!-- O el layout que uses -->

@section('content')
    <h1>Listado de Posts</h1>

    @if($posts->count())
        <ul>
            @foreach($posts as $post)
                <li>
                    <h2>{{ $post->titulo }}</h2>
                    <p>{{ Str::limit($post->contenido, 150) }}</p>
                    @if($post->imagen)
                        <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post" style="max-width:200px;">
                    @endif
                    <a href="{{ route('posts.show', $post->id) }}">Ver más</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay posts disponibles.</p>
    @endif
@endsection
