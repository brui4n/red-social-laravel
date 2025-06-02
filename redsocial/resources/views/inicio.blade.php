@extends('layouts.app')

@section('content')
    @auth
    <div class="container mt-5 text-center">
        <h1 class="display-4">¡Bienvenido, {{ Auth::user()->nombre }}!</h1>
        <p class="lead">Ya estás logueado correctamente en CodeNet.</p>

        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-4">Crear nuevo post</a>
        <a href="{{ route('posts.mis_posts') }}"class="btn btn-outline-info mb-4">Ver mis post</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger mt-3">Cerrar sesión</button>
        </form>
    </div>

    <div class="container mt-4">
        <h2>Posts recientes</h2>
        @if($posts->count())
            <ul class="list-group">
                @foreach($posts as $post)
                    <li class="list-group-item">
                        <h4>{{ $post->titulo }}</h4>
                        <p class="text-muted">Publicado por: {{ $post->usuario->nombre ?? 'Usuario desconocido' }}</p>
                        <p>{{ Str::limit($post->contenido, 100) }}</p>

                        @if($post->imagen)
                            <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post" style="max-width: 150px;">
                        @endif

                        <div class="mt-2">
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-secondary">Ver más</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No hay posts todavía.</p>
        @endif
    </div>
    @endauth
@endsection
