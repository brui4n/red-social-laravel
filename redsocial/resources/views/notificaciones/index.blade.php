@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">📋 Historial de Notificaciones</h2>

    @forelse($notificaciones as $notification)
        <div class="bg-white p-4 rounded shadow mb-2 border-l-4 border-blue-400 relative group">
            <form method="POST" action="{{ route('notificaciones.eliminar', $notification->id) }}"
                  class="absolute top-2 right-2 hidden group-hover:block">
                @csrf
                @method('DELETE')
                <button class="text-xs text-red-500 hover:text-red-700">❌</button>
            </form>

            <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="block">
                <strong>
                    {{ $notification->data['usuario_comentario'] ?? $notification->data['usuario_like'] ?? 'Alguien' }}
                </strong>
                {{ isset($notification->data['usuario_comentario']) ? 'comentó tu post:' : 'le dio like a tu post.' }}

                <div class="text-sm text-gray-600 mt-1">
                    {{ $notification->data['mensaje'] ?? 'Tienes una nueva notificación' }}
                </div>
            </a>
        </div>
    @empty
        <p class="text-gray-600">No tienes notificaciones aún.</p>
    @endforelse

    <div class="mt-4">
        {{ $notificaciones->links() }} {{-- Paginación --}}
    </div>
@endsection
