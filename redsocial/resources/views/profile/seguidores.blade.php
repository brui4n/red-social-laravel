@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h2 class="text-2xl font-bold mb-6">👥 Seguidores de {{ $user->nombre }}</h2>

        @if($seguidores->count())
            <ul class="space-y-5">
                @foreach($seguidores as $seguidor)
                    <li class="flex items-center gap-4 p-4 border border-gray-100 rounded-lg hover:shadow-sm transition">
                        <img class="w-12 h-12 rounded-full object-cover"
                             src="{{ $seguidor->avatar 
                                    ? asset('storage/' . $seguidor->avatar) 
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($seguidor->nombre) . '&color=7F9CF5&background=EBF4FF' }}"
                             alt="Avatar">

                        <div class="flex-1">
                            <a href="{{ route('profile.show', $seguidor) }}" class="text-lg font-semibold text-gray-800 hover:underline">
                                {{ $seguidor->nombre }}
                            </a>
                            <p class="text-sm text-gray-600">{{ '@' . $seguidor->username }}</p>
                        </div>

                        {{-- Opcional: botón seguir/dejar de seguir --}}
                        {{-- 
                        @if(Auth::check() && Auth::id() !== $seguidor->id)
                            <form method="POST" action="{{ route('profile.toggle-follow', $seguidor) }}">
                                @csrf
                                <button class="text-sm px-3 py-1 rounded 
                                               {{ Auth::user()->siguiendo->contains($seguidor->id) 
                                                   ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' 
                                                   : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                    {{ Auth::user()->siguiendo->contains($seguidor->id) ? 'Siguiendo' : 'Seguir' }}
                                </button>
                            </form>
                        @endif 
                        --}}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aún no tiene seguidores.</p>
        @endif
    </div>
</div>
@endsection
