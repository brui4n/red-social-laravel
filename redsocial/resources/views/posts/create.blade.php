@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Crear nuevo post</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong>¡Oops!</strong> Hay algunos problemas con tu entrada:
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow border">
        @csrf

        <div class="mb-4">
            <label for="titulo" class="block text-sm font-semibold text-gray-700">Título</label>
            <input type="text" name="titulo" required
                   class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label for="contenido" class="block text-sm font-semibold text-gray-700">Contenido</label>
            <textarea name="contenido" rows="4" required
                      class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <div class="mb-4">
            <label for="imagen" class="block text-sm font-semibold text-gray-700">Imagen (opcional)</label>
            <input type="file" name="imagen"
                   class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded cursor-pointer file:bg-blue-50 file:border-none file:rounded file:px-4 file:py-2 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <div class="mb-4">
            <label for="archivo" class="block text-sm font-semibold text-gray-700">Archivo adjunto (opcional)</label>
            <input type="file" name="archivo"
                   class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded cursor-pointer file:bg-green-50 file:border-none file:rounded file:px-4 file:py-2 file:text-green-700 hover:file:bg-green-100">
        </div>

        <div class="mb-4">
            <label for="codigo" class="block text-sm font-semibold text-gray-700">Código (opcional)</label>
            <textarea name="codigo" rows="5"
                      class="mt-1 block w-full font-mono text-sm border border-gray-300 rounded px-4 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <div class="mb-6">
            <label for="lenguaje" class="block text-sm font-semibold text-gray-700">Lenguaje del código (opcional)</label>
            <select name="lenguaje"
                    class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Selecciona un lenguaje</option>
                <option value="php">PHP</option>
                <option value="javascript">JavaScript</option>
                <option value="html">HTML</option>
                <option value="css">CSS</option>
                <option value="python">Python</option>
                <option value="java">Java</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition text-sm font-semibold">
                Publicar
            </button>
            <a href="{{ route('inicio') }}"
               class="text-red-600 hover:underline text-sm">Cancelar</a>
        </div>
    </form>
</div>
@endsection
