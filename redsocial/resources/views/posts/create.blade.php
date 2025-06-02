@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear nuevo post</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Oops!</strong> Hay algunos problemas con tu entrada.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea name="contenido" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen (opcional)</label>
            <input type="file" name="imagen" class="form-control">
        </div>

        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo adjunto (opcional)</label>
            <input type="file" name="archivo" class="form-control">
        </div>

        <div class="mb-3">
            <label for="codigo" class="form-label">Código (opcional)</label>
            <textarea name="codigo" class="form-control" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label for="lenguaje" class="form-label">Lenguaje del código (opcional)</label>
            <select name="lenguaje" class="form-select">
                <option value="">Selecciona un lenguaje</option>
                <option value="php">PHP</option>
                <option value="javascript">JavaScript</option>
                <option value="html">HTML</option>
                <option value="css">CSS</option>
                <option value="python">Python</option>
                <option value="java">Java</option>
                <!-- Agrega más si gustas -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Publicar</button>
        <a href="{{ route('inicio') }}" class="btn btn-danger mt-3">Cancelar</a>
    </form>
</div>
@endsection
