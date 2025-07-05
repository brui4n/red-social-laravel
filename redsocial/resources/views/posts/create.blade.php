@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    {{-- Título --}}
    <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">📝 Crear nuevo post</h2>

    {{-- Errores --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-8">
            <strong>Ups... hubo algunos errores:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 space-y-6">
        @csrf

        {{-- Título --}}
        <div>
            <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-1">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo') }}" required
                   class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        {{-- Contenido --}}
        <div>
            <label for="contenido" class="block text-sm font-semibold text-gray-700 mb-1">Contenido</label>
            <textarea name="contenido" rows="4" required
                      class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ old('contenido') }}</textarea>
        </div>

        {{-- Imagen --}}
        <div>
            <label for="imagen" class="block text-sm font-semibold text-gray-700 mb-1">Imagen (opcional)</label>
            <input type="file" name="imagen"
                   class="w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer file:bg-blue-50 file:border-none file:px-4 file:py-2 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        {{-- Archivo --}}
        <div>
            <label for="archivo" class="block text-sm font-semibold text-gray-700 mb-1">Archivo adjunto (opcional)</label>
            <input type="file" name="archivo"
                   class="w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer file:bg-green-50 file:border-none file:px-4 file:py-2 file:text-green-700 hover:file:bg-green-100">
        </div>

        {{-- Código --}}
        <div>
            <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-1">Código fuente (opcional)</label>
            <textarea name="codigo" rows="5"
                      class="w-full font-mono text-sm bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ old('codigo') }}</textarea>
        </div>

        {{-- Lenguaje --}}
        <div>
            <label for="lenguaje" class="block text-sm font-semibold text-gray-700 mb-1">Lenguaje del código</label>
            <select name="lenguaje"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">Selecciona un lenguaje</option>
                <option value="php" {{ old('lenguaje') == 'php' ? 'selected' : '' }}>PHP</option>
                <option value="javascript" {{ old('lenguaje') == 'javascript' ? 'selected' : '' }}>JavaScript</option>
                <option value="html" {{ old('lenguaje') == 'html' ? 'selected' : '' }}>HTML</option>
                <option value="css" {{ old('lenguaje') == 'css' ? 'selected' : '' }}>CSS</option>
                <option value="python" {{ old('lenguaje') == 'python' ? 'selected' : '' }}>Python</option>
                <option value="java" {{ old('lenguaje') == 'java' ? 'selected' : '' }}>Java</option>
            </select>
        </div>

        {{-- Etiquetas --}}
        <div>
            <label for="tags" class="block text-sm font-semibold text-gray-700 mb-1">Etiquetas</label>
            <select name="tags[]" id="tags" multiple
                    class="w-full border border-gray-300 rounded-lg p-2 bg-white shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ collect(old('tags', $selectedTags ?? []))->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Ctrl (o Cmd) + clic para seleccionar varias.</p>
        </div>

        {{-- Botones --}}
        <div class="flex items-center justify-between pt-4 border-t">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-all shadow">
                🚀 Publicar
            </button>
            <a href="{{ route('inicio') }}" class="text-red-600 hover:underline text-sm font-medium">Cancelar</a>
        </div>
    </form>
</div>
@endsection
