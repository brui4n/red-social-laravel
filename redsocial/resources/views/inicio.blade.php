@extends('layouts.app')


@section('content')
    @auth
    <div class="container mt-5 text-center">
        <h1 class="display-4">¡Bienvenido, {{ Auth::user()->nombre }}!</h1>
        <p class="lead">Ya estás logueado correctamente en CodeNet.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger mt-3">Cerrar sesión</button>
        </form>
    </div>
    @endauth
@endsection