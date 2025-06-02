@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $post->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea name="contenido" class="form-control" rows="3" required>{{ old('contenido', $post->contenido) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="codigo" class="form-label">Código (opcional)</label>
            <textarea name="codigo" class="form-control" rows="4">{{ old('codigo', $post->codigo) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="lenguaje" class="form-label">Lenguaje</label>
            <select name="lenguaje" class="form-select">
                <option value="">-- Selecciona uno --</option>
                <option value="php" {{ $post->lenguaje == 'php' ? 'selected' : '' }}>PHP</option>
                <option value="javascript" {{ $post->lenguaje == 'javascript' ? 'selected' : '' }}>JavaScript</option>
                <option value="python" {{ $post->lenguaje == 'python' ? 'selected' : '' }}>Python</option>
                <option value="html" {{ $post->lenguaje == 'html' ? 'selected' : '' }}>HTML</option>
                
            </select>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen (opcional)</label>
            <input type="file" name="imagen" class="form-control">
        </div>

        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo (opcional)</label>
            <input type="file" name="archivo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
