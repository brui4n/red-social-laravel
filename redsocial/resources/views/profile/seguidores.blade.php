@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h2 class="text-2xl font-bold mb-4">👥 Seguidores de {{ $user->nombre }}</h2>

        @if($seguidores->count())
            <ul class="space-y-4">
                @foreach($seguidores as $seguidor)
                    <li class="flex items-center gap-4 p-3 border rounded-lg">
                        <img class="w-12 h-12 rounded-full object-cover"
                             src="{{ $seguidor->avatar ? asset('storage/' . $seguidor->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($seguidor->nombre) . '&color=7F9CF5&background=EBF4FF' }}"
                             alt="Avatar">

                        <div class="flex-1">
                            <a href="{{ route('profile.show', $seguidor) }}" class="font-semibold text-gray-800 hover:underline">
                                {{ $seguidor->nombre }}
                            </a>
                            <p class="text-sm text-gray-600">{{ '@' . $seguidor->username }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aún no tiene seguidores.</p>
        @endif
    </div>
</div>
@endsection
