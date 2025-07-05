@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">📋 Historial de Notificaciones</h2>

        @forelse($notificaciones as $notification)
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-blue-500 relative group hover:shadow-md transition">
                {{-- Botón eliminar (sólo visible al pasar el mouse) --}}
                <form method="POST" action="{{ route('notificaciones.eliminar', $notification->id) }}"
                      class="absolute top-2 right-3 hidden group-hover:block">
                    @csrf
                    @method('DELETE')
                    <button class="text-xs text-red-500 hover:text-red-700">❌</button>
                </form>

                {{-- Contenido de notificación --}}
                <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="block">
                    <p class="text-gray-800 font-medium">
                        <strong>
                            {{ $notification->data['usuario_comentario'] ?? $notification->data['usuario_like'] ?? 'Alguien' }}
                        </strong>
                        {{ isset($notification->data['usuario_comentario']) ? 'comentó tu post:' : 'le dio like a tu post.' }}
                    </p>

                    <p class="text-sm text-gray-600 mt-1">
                        {{ $notification->data['mensaje'] ?? 'Tienes una nueva notificación' }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </a>
            </div>
        @empty
            <p class="text-gray-600 text-center">🕊️ No tienes notificaciones aún.</p>
        @endforelse

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $notificaciones->links() }}
        </div>
    </div>
@endsection
